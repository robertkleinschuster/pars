<?php

namespace Pars\Core\Router;

use Psr\Http\Server\RequestHandlerInterface;

class RouteFactory
{
    public function createAny(RequestHandlerInterface $handler): AnyRoute
    {
        return new AnyRoute($handler);
    }

    public function createHeader(RouteInterface $route, string $name, string $value): HeaderRoute
    {
        return new HeaderRoute($route, $name, $value);
    }

    public function createMethod(RouteInterface $route, string $method): MethodRoute
    {
        return new MethodRoute($route, $method);
    }

    public function createPattern(RouteInterface $route, string $pattern): PatternRoute
    {
        return new PatternRoute($route, $pattern);
    }
}
