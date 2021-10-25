<?php

namespace App\Modules\Songlist\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistList;
use Illuminate\Http\Request;


/**
 * SonglistIndexAction
 */
class SonglistIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistList $domain, SonglistIndexResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }


    function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
