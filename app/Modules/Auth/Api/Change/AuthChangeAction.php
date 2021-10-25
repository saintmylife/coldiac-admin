<?php

namespace App\Modules\Auth\Api\Change;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Domain\Service\AuthChange;
use Illuminate\Http\Request;

/**
 * AuthChange action
 */
class AuthChangeAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(AuthChange $domain, AuthChangeResponder $responder)
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
