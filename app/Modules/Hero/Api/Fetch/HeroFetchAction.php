<?php

namespace App\Modules\Hero\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Domain\Service\HeroFetch;
use Illuminate\Http\Request;

/**
 * HeroFetchAction
 */
class HeroFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(HeroFetch $domain, HeroFetchResponder $responder)
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
