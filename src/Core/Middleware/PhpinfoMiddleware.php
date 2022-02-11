<?php

namespace Pars\Core\Middleware;

use GuzzleHttp\Psr7\Response;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PhpinfoMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new Response(200, [], new ClosureStream(phpinfo(...)));
    }

}