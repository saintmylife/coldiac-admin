<?php

namespace App\Modules\Hero\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Domain\Service\HeroEdit;
use Illuminate\Http\Request;

/**
 * HeroEditAction
 */
class HeroEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(HeroEdit $domain, HeroEditResponder $responder)
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
