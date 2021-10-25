<?php

namespace App\Modules\Generator\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Generator\Domain\Service\GeneratorList;
use Illuminate\Http\Request;


/**
 * GeneratorIndexAction
 */
class GeneratorIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GeneratorList $domain, GeneratorIndexResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }


    function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
