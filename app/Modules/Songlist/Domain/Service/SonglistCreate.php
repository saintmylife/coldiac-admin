<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Domain\SonglistFilter;
use App\Jobs\InsertImage;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;
use App\Modules\Songlist\SonglistDto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * SonglistCreate domain
 */
class SonglistCreate extends BaseService
{
    private $filter;
    private $songlistRepo;

    public function __construct(SonglistFilter $filter, SonglistRepositoryInterface $songlistRepo)
    {
        $this->filter = $filter;
        $this->songlistRepo = $songlistRepo;
    }

    public function __invoke(array $data): Payload
    {

        $songlistDto = $this->makeDto($data, new SonglistDto);

        if (!$this->filter->forInsert($songlistDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $filename = Str::uuid() . '.jpg';
        $path = 'songlist/';
        Storage::putFileAs('public/' . $path, $songlistDto->thumb, $filename);
        $songlistDto->thumb = $filename;
        $songlistDto->active = 0;
        $create = $this->songlistRepo->create($songlistDto->getData());
        InsertImage::dispatchNow($path, $filename);

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
