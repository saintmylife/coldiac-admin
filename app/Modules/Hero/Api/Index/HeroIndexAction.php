<?php

namespace App\Modules\Hero\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Domain\Service\HeroList;
use Illuminate\Http\Request;


/**
 * HeroIndexAction
 */
class HeroIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(HeroList $domain, HeroIndexResponder $responder)
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
