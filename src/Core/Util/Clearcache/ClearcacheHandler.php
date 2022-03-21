<?php

namespace Pars\Core\Util\Clearcache;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;

class ClearcacheHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (function_exists('opcache_reset')) {
            opcache_reset();
            opcache_reset();
        }
        return response('done');
    }
}
