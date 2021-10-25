<?php

namespace App\Modules\Songlist\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistFetch;
use Illuminate\Http\Request;

/**
 * SonglistFetchAction
 */
class SonglistFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistFetch $domain, SonglistFetchResponder $responder)
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
