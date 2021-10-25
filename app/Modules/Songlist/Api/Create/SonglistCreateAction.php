<?php

namespace App\Modules\Songlist\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistCreate;
use Illuminate\Http\Request;

/**
 * SonglistCreateAction
 */
class SonglistCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistCreate $domain, SonglistCreateResponder $responder)
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
