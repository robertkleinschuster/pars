<?php

declare(strict_types=1);

namespace Pars\Core\Application;

use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Laminas\Stratigility\MiddlewarePipeInterface;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Mezzio\Router\RouteCollectorInterface;
use Pars\Core\Application\Event\Message\ApplicationMessageListener;
use Pars\Core\Application\Socket\WebSocketMiddleware;

abstract class AbstractApplication extends Application
{
    private ApplicationContainer $container;

    public function __construct(ApplicationContainer $container)
    {
        $this->container = $container;
        parent::__construct(
            $container->get(MiddlewareFactory::class),
            $container->get(MiddlewarePipeInterface::class),
            $container->get(RouteCollectorInterface::class),
            $container->get(RequestHandlerRunnerInterface::class)
        );
        $this->pipe(WebSocketMiddleware::class);
        $this->pipe(RouteMiddleware::class);
        $this->init();
        $this->pipe(ImplicitHeadMiddleware::class);
        $this->pipe(ImplicitOptionsMiddleware::class);
        $this->pipe(MethodNotAllowedMiddleware::class);
        $this->pipe(DispatchMiddleware::class);
        $this->pipe(NotFoundHandler::class);
    }

    abstract protected function init();

    public function getContainer(): ApplicationContainer
    {
        return $this->container;
    }

    public function getMessageListener(): ApplicationMessageListener
    {
        return $this->getContainer()->get(ApplicationMessageListener::class);
    }

    public function message(callable $handler): self
    {
        $this->getMessageListener()->addHandler($handler);
        return $this;
    }
}
