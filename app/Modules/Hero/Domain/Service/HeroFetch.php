<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Repository\HeroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Hero delete
 */
class HeroFetch extends BaseService
{
    private $heroRepo;

    public function __construct(HeroRepositoryInterface $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->heroRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
