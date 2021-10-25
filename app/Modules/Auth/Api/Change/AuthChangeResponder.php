<?php

namespace App\Modules\Auth\Api\Change;

use App\Modules\Base\Domain\BaseResponder;

/**
 * AuthChange responder
 */
class AuthChangeResponder extends BaseResponder
{
    public function authenticated(): void
    {
        $this->renderResult();
    }

    public function authFailed(): void
    {
        $this->response = response()->json($this->payload->getResult(), 401);
    }
}
