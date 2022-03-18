<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplStack;

class RequestRouter implements MiddlewareInterface
{
    /**
     * @var iterable<Route>&SplStack<Route>
     */
    protected SplStack $routes;

    public function __construct()
    {
        $this->routes = new SplStack();
    }

    public function __clone()
    {
        $this->routes = clone $this->routes;
    }

    public function with(string $route, RequestHandlerInterface $handler): RequestRouter
    {
        $clone = clone $this;
        $clone->routes->push(create(Route::class, $handler, $route));
        return $clone;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->routes as $route) {
            $matchedRequest = $route->match($request);
            if ($matchedRequest) {
                return $route->handler->handle($matchedRequest->withAttribute(RequestRouter::class, $this));
            }
        }
        return $handler->handle($request);
    }
}
