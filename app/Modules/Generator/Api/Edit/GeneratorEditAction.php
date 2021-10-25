<?php

namespace App\Modules\Generator\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Generator\Domain\Service\GeneratorEdit;
use Illuminate\Http\Request;

/**
 * GeneratorEditAction
 */
class GeneratorEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GeneratorEdit $domain, GeneratorEditResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
