<?php

namespace Pars\Core\Router;

use Psr\Http\Server\RequestHandlerInterface;

class RouteFactory
{
    public function createRoute(RequestHandlerInterface $handler, string $route): Route
    {
        return new Route($handler, $route);
    }
}
