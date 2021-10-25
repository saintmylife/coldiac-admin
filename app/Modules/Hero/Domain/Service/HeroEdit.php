<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Domain\HeroFilter;
use App\Modules\Hero\HeroDto;
use App\Modules\Hero\Repository\HeroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\InsertImage;

/**
 * HeroEdit service
 */
class HeroEdit extends BaseService
{
    private $filter;
    private $heroRepo;

    public function __construct(HeroFilter $filter, HeroRepositoryInterface $heroRepo)
    {
        $this->filter = $filter;
        $this->heroRepo = $heroRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $heroDto = $this->makeDto($data, new HeroDto);
        $heroDto->id = $id;

        try {
            $hero = $this->heroRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdate($heroDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        foreach ($heroDto->getData() as $key => $value) {
            if ($key !== 'id' && $hero[$key] !== $value && !is_null($value)) {
                $hero[$key] = $value;
            }
            if (is_null($value)) {
                $heroDto->$key = $hero[$key];
            }
        }
        if (!$hero->isDirty()) {
            return $this->newPayload(Payload::STATUS_NOT_UPDATED);
        }
        if (is_file($heroDto->image)) {
            $filename = Str::uuid() . '.jpg';
            $path = 'hero/';
            Storage::delete('public/' . $path . $hero->getOriginal('image'));
            Storage::putFileAs('public/' . $path, $heroDto->image, $filename);
            $heroDto->image = $filename;
            InsertImage::dispatchNow($path, $filename);
        }

        $dataForDb = $heroDto->getData();
        $update = $this->heroRepo->update($dataForDb, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
