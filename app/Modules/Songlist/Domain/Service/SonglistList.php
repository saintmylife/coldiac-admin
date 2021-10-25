<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;

/**
 * SonglistList service
 */
class SonglistList extends BaseService
{
    private $songlistRepo;

    public function __construct(SonglistRepositoryInterface $songlistRepo)
    {
        $this->songlistRepo = $songlistRepo;
    }

    public function __invoke($request)
    {
        $data = $this->songlistRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
