<?php

namespace App\Modules\Hero\Api\Active;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Domain\Service\HeroActive;
use Illuminate\Http\Request;

/**
 * HeroActiveAction
 */
class HeroActiveAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(HeroActive $domain, HeroActiveResponder $responder)
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
