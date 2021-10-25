<?php

namespace App\Modules\Songlist\Api\Order;

use App\Http\Controllers\Controller;
use App\Modules\Songlist\Domain\Service\SonglistOrder;
use Illuminate\Http\Request;

/**
 * SonglistOrderAction
 */
class SonglistOrderAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(SonglistOrder $domain, SonglistOrderResponder $responder)
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
