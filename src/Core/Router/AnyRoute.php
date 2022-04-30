<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AnyRoute implements RouteInterface
{
    use RouteTrait;

    private RequestHandlerInterface $handler;

    public function __construct(RequestHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function match(ServerRequestInterface $request): void
    {
        $this->matchedRequest = $request->withAttribute(AnyRoute::class, $this);
    }

    public function getHandler(): RequestHandlerInterface
    {
        return $this->handler;
    }
}
