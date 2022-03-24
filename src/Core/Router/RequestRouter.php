<?php

namespace Pars\Core\Router;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use SplQueue;

class RequestRouter implements MiddlewareInterface
{
    /**
     * @var iterable<Route>&SplQueue<Route>
     */
    protected SplQueue $routes;
    protected RouteFactory $routeFactory;

    public function __construct(RouteFactory $routeFactory)
    {
        $this->routes = new SplQueue();
        $this->routeFactory = $routeFactory;
    }

    public function __clone()
    {
        $this->routes = clone $this->routes;
    }

    public function with(string $route, RequestHandlerInterface $handler): RequestRouter
    {
        $clone = clone $this;
        $clone->routes->push($this->routeFactory->createRoute($handler, $route));
        return $clone;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->routes as $route) {
            if ($route->isMatched()) {
                continue;
            }
            $matchedRequest = $route->match($request);
            if ($matchedRequest) {
                return $route->handler->handle($matchedRequest->withAttribute(RequestRouter::class, $this));
            }
        }
        return $handler->handle($request);
    }
}
