<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Domain\HeroFilter;
use App\Modules\Hero\HeroDto;
use App\Modules\Hero\Repository\HeroRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Jobs\InsertImage;

/**
 * HeroCreate domain
 */
class HeroCreate extends BaseService
{
    private $filter;
    private $heroRepo;

    public function __construct(HeroFilter $filter, HeroRepositoryInterface $heroRepo)
    {
        $this->filter = $filter;
        $this->heroRepo = $heroRepo;
    }

    public function __invoke(array $data): Payload
    {

        $heroDto = $this->makeDto($data, new HeroDto);
        $heroDto->active = 0;

        if (!$this->filter->forInsert($heroDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $filename = Str::uuid() . '.jpg';
        $path = 'hero/';
        Storage::putFileAs('public/' . $path, $heroDto->image, $filename);
        $heroDto->image = $filename;
        $heroDto->active = 0;
        $create = $this->heroRepo->create($heroDto->getData());
        InsertImage::dispatchNow($path, $filename);

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
