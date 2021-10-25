<?php

namespace App\Modules\Songlist\Api\Active;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistActive;
use Illuminate\Http\Request;

/**
 * SonglistActiveAction
 */
class SonglistActiveAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistActive $domain, SonglistActiveResponder $responder)
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
