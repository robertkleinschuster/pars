<?php

namespace Pars\Core\Router;

use Pars\Core\Http\Uri\UriBuilder;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use SplQueue;

class RequestRouter implements MiddlewareInterface
{
    /**
     * @var iterable<RouteInterface>&SplQueue<RouteInterface>
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

    public function push(RouteInterface $route): self
    {
        $this->routes->push($route);
        return $this;
    }

    public function route(RequestHandlerInterface $handler): AggregatedRoute
    {
        $route = new AggregatedRoute($handler);
        $this->push($route);
        return $route;
    }

    public function get(string $pattern, RequestHandlerInterface $handler): AggregatedRoute
    {
        return $this->route($handler)
            ->pattern($pattern)
            ->method('GET');
    }

    public function post(string $pattern, RequestHandlerInterface $handler): AggregatedRoute
    {
        return $this->route($handler)
            ->pattern($pattern)
            ->method('POST');
    }

    public function put(string $pattern, RequestHandlerInterface $handler): AggregatedRoute
    {
        return $this->route($handler)
            ->pattern($pattern)
            ->method('PUT');
    }

    public function patch(string $pattern, RequestHandlerInterface $handler): AggregatedRoute
    {
        return $this->route($handler)
            ->pattern($pattern)
            ->method('PATCH');
    }


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws UnmatchedRouteException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->routes as $route) {
            if ($route->isMatched()) {
                continue;
            }
            $route->match($request);
            if ($route->isMatched()) {
                $matchedRequest = $route->getMatchedRequest();
                $this->uriBuilder->setCurrentUri($matchedRequest->getUri());
                return $route->getHandler()->handle($matchedRequest->withAttribute(RequestRouter::class, $this));
            }
        }
        return $handler->handle($request);
    }
}
