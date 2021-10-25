<?php

namespace App\Modules\Hero\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Hero\Repository\HeroRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

/**
 * Hero delete
 */
class HeroDelete extends BaseService
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
        Storage::delete('public/hero/' . $data->image);
        $this->heroRepo->delete($id);
        $message = 'Hero Deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
