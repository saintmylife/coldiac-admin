<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Domain\SonglistFilter;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;
use App\Modules\Songlist\SonglistDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Jobs\InsertImage;

/**
 * SonglistEdit service
 */
class SonglistEdit extends BaseService
{
    private $filter;
    private $songlistRepo;

    public function __construct(SonglistFilter $filter, SonglistRepositoryInterface $songlistRepo)
    {
        $this->filter = $filter;
        $this->songlistRepo = $songlistRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $songlistDto = $this->makeDto($data, new SonglistDto);
        $songlistDto->id = $id;

        try {
            $songlist = $this->songlistRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdate($songlistDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        foreach ($songlistDto->getData() as $key => $value) {
            if ($key !== 'id' && $songlist[$key] !== $value && !is_null($value)) {
                $songlist[$key] = $value;
            }
            if (is_null($value)) {
                $songlistDto->$key = $songlist[$key];
            }
        }
        if (!$songlist->isDirty()) {
            return $this->newPayload(Payload::STATUS_NOT_UPDATED);
        }

        if (is_file($songlistDto->thumb)) {
            $filename = Str::uuid() . '.jpg';
            $path = 'songlist/';
            Storage::delete('public/' . $path . $songlist->getOriginal('thumb'));
            Storage::putFileAs('public/' . $path, $songlistDto->thumb, $filename);
            $songlistDto->thumb = $filename;
            InsertImage::dispatchNow($path, $filename);
        }

        $update = $this->songlistRepo->update($songlistDto->getData(), $id);
        $data = $songlistDto->getData();

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
