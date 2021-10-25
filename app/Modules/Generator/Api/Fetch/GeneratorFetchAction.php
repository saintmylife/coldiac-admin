<?php

namespace App\Modules\Generator\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Generator\Domain\Service\GeneratorFetch;
use Illuminate\Http\Request;

/**
 * GeneratorFetchAction
 */
class GeneratorFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GeneratorFetch $domain, GeneratorFetchResponder $responder)
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
