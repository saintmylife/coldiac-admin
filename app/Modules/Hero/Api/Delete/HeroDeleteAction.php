<?php

namespace App\Modules\Hero\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Hero\Domain\Service\HeroDelete;

/**
 * Hero action
 */
class HeroDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(HeroDelete $domain, HeroDeleteResponder $responder)
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
