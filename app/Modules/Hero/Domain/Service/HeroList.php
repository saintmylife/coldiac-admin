<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Repository\HeroRepositoryInterface;

/**
 * HeroList service
 */
class HeroList extends BaseService
{
    private $heroRepo;

    public function __construct(HeroRepositoryInterface $heroRepo)
    {
        $this->heroRepo = $heroRepo;
    }

    public function __invoke($request)
    {
        $data = $this->heroRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
