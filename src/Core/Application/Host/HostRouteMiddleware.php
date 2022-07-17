<?php

namespace Pars\Core\Application\Host;

use Mezzio\MiddlewareFactory;
use Mezzio\Router\Route;
use Mezzio\Router\RouteResult;
use Pars\Core\Application\AbstractApplication;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HostRouteMiddleware implements MiddlewareInterface
{
    private MiddlewareFactory $middlewareFactory;
    private array $hosts;

    /**
     * @param MiddlewareFactory $middlewareFactory
     * @param array $hosts
     */
    public function __construct(MiddlewareFactory $middlewareFactory, array $hosts)
    {
        $this->middlewareFactory = $middlewareFactory;
        $this->hosts = $hosts;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $host = $request->getUri()->getHost();
        if (isset($this->hosts[$host])) {
            $middleware = $this->middlewareFactory->prepare($this->hosts[$host]);
            return $handler->handle(
                $request->withAttribute(
                    RouteResult::class,
                    RouteResult::fromRoute(
                        new Route(
                            '*',
                            $middleware
                        )
                    )
                )
            );
        }
        return $handler->handle($request);
    }
}