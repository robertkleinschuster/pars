<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

trait ParentRouteTrait
{
    use RouteTrait;

    private RouteInterface $route;

    private function matchChildRoute(ServerRequestInterface $request): void
    {
        $this->route->match($request->withAttribute(get_class($this), $this));
        if ($this->route->isMatched()) {
            $this->matchedRequest = $this->route->getMatchedRequest();
        }
    }

    public function getHandler(): RequestHandlerInterface
    {
        return $this->route->getHandler();
    }

    public function __clone(): void
    {
        $this->route = clone $this->route;
    }
}
