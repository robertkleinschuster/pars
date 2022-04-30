<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;

class MethodRoute implements RouteInterface
{
    use ParentRouteTrait;

    private string $method;

    public function __construct(RouteInterface $route, string $method)
    {
        $this->route = $route;
        $this->method = $method;
    }

    public function match(ServerRequestInterface $request): void
    {
        if ($this->matchMethod($request)) {
            $this->matchChildRoute($request);
        }
    }

    private function matchMethod(ServerRequestInterface $request)
    {
        return $request->getMethod() === $this->method;
    }
}