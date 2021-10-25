<?php

namespace App\Modules\Generator\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Generator\Domain\Service\GeneratorCreate;
use Illuminate\Http\Request;

/**
 * GeneratorCreateAction
 */
class GeneratorCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GeneratorCreate $domain, GeneratorCreateResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
