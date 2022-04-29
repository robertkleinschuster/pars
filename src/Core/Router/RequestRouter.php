<?php

namespace Pars\Core\Router;

use Pars\Core\Http\Uri\UriBuilder;
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
    private UriBuilder $uriBuilder;

    public function __construct(RouteFactory $routeFactory, UriBuilder $uriBuilder)
    {
        $this->routes = new SplQueue();
        $this->routeFactory = $routeFactory;
        $this->uriBuilder = $uriBuilder;
    }

    public function __clone()
    {
        $this->routes = clone $this->routes;
    }

    public function with(string $route, RequestHandlerInterface $handler, string $method = 'GET'): RequestRouter
    {
        $clone = clone $this;
        $route = $this->routeFactory->createRoute($handler, $route);
        $route->setMethod($method);
        $clone->routes->push($route);
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
                $this->uriBuilder->setCurrentUri($matchedRequest->getUri());
                return $route->handler->handle($matchedRequest->withAttribute(RequestRouter::class, $this));
            }
        }
        return $handler->handle($request);
    }
}
