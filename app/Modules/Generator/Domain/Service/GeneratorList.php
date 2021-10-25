<?php

namespace App\Modules\Generator\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Generator\Repository\GeneratorRepositoryInterface;

/**
 * GeneratorList service
 */
class GeneratorList extends BaseService
{
    private $generatorRepo;

    public function __construct(GeneratorRepositoryInterface $generatorRepo)
    {
        $this->generatorRepo = $generatorRepo;
    }

    public function __invoke($request)
    {
        $data = $this->generatorRepo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
