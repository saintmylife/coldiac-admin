<?php

namespace App\Modules\Songlist\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistEdit;
use Illuminate\Http\Request;

/**
 * SonglistEditAction
 */
class SonglistEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistEdit $domain, SonglistEditResponder $responder)
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
