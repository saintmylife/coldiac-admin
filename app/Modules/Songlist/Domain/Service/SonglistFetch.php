<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Songlist delete
 */
class SonglistFetch extends BaseService
{
    private $songlistRepo;

    public function __construct(SonglistRepositoryInterface $songlistRepo)
    {
        $this->songlistRepo = $songlistRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->songlistRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
