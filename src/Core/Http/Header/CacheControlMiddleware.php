<?php

namespace Pars\Core\Http\Header;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CacheControlMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $response = $response->withAddedHeader('Pragma', 'no-cache');
        $response = $response->withAddedHeader('Cache-Control', 'no-cache, must-revalidate');
        return $response->withAddedHeader('X-Accel-Buffering', 'no');
    }
}
