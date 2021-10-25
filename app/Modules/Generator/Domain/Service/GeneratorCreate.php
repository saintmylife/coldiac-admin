<?php

namespace App\Modules\Generator\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Generator\Domain\GeneratorFilter;
use App\Modules\Generator\GeneratorDto;
use App\Modules\Generator\Repository\GeneratorRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * GeneratorCreate domain
 */
class GeneratorCreate extends BaseService
{
    private $filter;
    private $generatorRepo;

    public function __construct(GeneratorFilter $filter, GeneratorRepositoryInterface $generatorRepo)
    {
        $this->filter = $filter;
        $this->generatorRepo = $generatorRepo;
    }

    public function __invoke(array $data): Payload
    {

        $generatorDto = $this->makeDto($data, new GeneratorDto);

        if (!$this->filter->forInsert($generatorDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $create = $this->generatorRepo->create($generatorDto->getData());
        /*
        $generatorDto->password = Hash::make($generatorDto->password);
        //$create->syncRoles('Personal');
        */

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
