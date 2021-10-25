<?php

namespace App\Modules\Generator\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Generator\Repository\GeneratorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Generator delete
 */
class GeneratorDelete extends BaseService
{
    private $generatorRepo;

    public function __construct(GeneratorRepositoryInterface $generatorRepo)
    {
        $this->generatorRepo = $generatorRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->generatorRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        try {
            Gate::authorize('owner', $data->event->user_id);
        } catch (AuthorizationException $e) {
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }

        $this->generatorRepo->delete($id);
        $message = 'generator deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
