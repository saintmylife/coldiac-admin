<?php

namespace App\Modules\Generator\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Generator\Domain\Service\GeneratorDelete;

/**
 * Generator action
 */
class GeneratorDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GeneratorDelete $domain, GeneratorDeleteResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
