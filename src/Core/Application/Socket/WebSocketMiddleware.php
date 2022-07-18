<?php

namespace Pars\Core\Application\Socket;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WebSocketMiddleware implements MiddlewareInterface
{
    private WebSocketContainer $container;

    /**
     * @param WebSocketContainer $container
     */
    public function __construct(WebSocketContainer $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();
        $socket = new WebSocket($cookies['client'] ?? '');
        $this->container->add($socket);
        return $handler->handle(
            $request
                ->withAttribute(WebSocket::class, $socket)
        );
    }
}