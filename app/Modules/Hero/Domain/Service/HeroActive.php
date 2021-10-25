<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Domain\HeroFilter;
use App\Modules\Hero\Repository\HeroRepositoryInterface;
use App\Modules\Hero\HeroDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

/**
 * HeroActive service
 */
class HeroActive extends BaseService
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
        $heroDto->active = (int)!$hero->active;
        if (!$this->filter->forUpdateActive($heroDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $dataForUpdate = [
            'active' => $heroDto->active
        ];
        if (!$heroDto->active) {
            $dataForUpdate['order'] = null;
        }
        $update = $this->heroRepo->update($dataForUpdate, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
