<?php

namespace Pars\Core\Application\Client;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClientMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();
        $cookies['client'] = uniqid();
        return $handler->handle($request->withCookieParams($cookies))
            ->withAddedHeader('Set-Cookie', 'client=' . $cookies['client']);
    }
}
