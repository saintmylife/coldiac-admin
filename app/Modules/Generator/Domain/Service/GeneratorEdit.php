<?php

namespace App\Modules\Generator\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Generator\Domain\GeneratorFilter;
use App\Modules\Generator\GeneratorDto;
use App\Modules\Generator\Repository\GeneratorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * GeneratorEdit service
 */
class GeneratorEdit extends BaseService
{
    private $filter;
    private $generatorRepo;

    public function __construct(GeneratorFilter $filter, GeneratorRepositoryInterface $generatorRepo)
    {
        $this->filter = $filter;
        $this->generatorRepo = $generatorRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $generatorDto = $this->makeDto($data, new GeneratorDto);
        $generatorDto->id = $id;

        try {
             $generator = $this->generatorRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        try{
            Gate::authorize('owner', $generator->user_id);
        } catch (AuthorizationException $e){
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }

        if (! $this->filter->forUpdate($generatorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $dataForDb = $generatorDto->getData();

        $update = $this->generatorRepo->update($dataForDb, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
