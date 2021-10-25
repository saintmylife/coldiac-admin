<?php

namespace App\Modules\Songlist\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistDelete;

/**
 * Songlist action
 */
class SonglistDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistDelete $domain, SonglistDeleteResponder $responder)
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
