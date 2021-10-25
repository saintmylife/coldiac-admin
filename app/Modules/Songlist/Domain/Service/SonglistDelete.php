<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

/**
 * Songlist delete
 */
class SonglistDelete extends BaseService
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
        Storage::delete('public/songlist/' . $data->thumb);
        $this->songlistRepo->delete($id);
        $message = 'Songlist Deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
