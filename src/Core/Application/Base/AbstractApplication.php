<?php

namespace Pars\Core\Application\Base;

use Pars\Core\{Application\ApplicationContainer,
    Config\Config,
    Container\ContainerResolver,
    Error\ErrorMiddleware,
    Http\HttpFactory,
    Pipeline\MiddlewarePipeline,
    Router\AggregatedRoute,
    Router\RequestRouter,
    Router\RouteInterface};
use Pars\Core\Error\NotFound\NotFoundHandler;
use Pars\Core\Http\Emitter\SapiEmitter;
use Pars\Core\Http\Header\CacheControlMiddleware;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

abstract class AbstractApplication implements RequestHandlerInterface, MiddlewareInterface
{
    private ApplicationContainer $container;
    private MiddlewarePipeline $pipeline;
    private RequestRouter $router;
    private Config $config;
    private RequestHandlerInterface $handler;
    private HttpFactory $http;
    private ServerRequestInterface $request;

    public function __construct(ApplicationContainer $container = null)
    {
        if (null !== $container) {
            $this->container = $container;
        }
    }

    public function __clone()
    {
        if (isset($this->pipeline)) {
            $this->pipeline = clone $this->pipeline;
        }
        if (isset($this->router)) {
            $this->router = clone $this->router;
        }
        if (isset($this->config)) {
            $this->config = clone $this->config;
        }
        if (isset($this->handler)) {
            $this->handler = clone $this->handler;
        }
    }

    abstract protected function init();

    public function pipe($middlewareOrPath, MiddlewareInterface $middleware = null): self
    {
        $this->pipeline = $this->getPipeline()->with($middlewareOrPath, $middleware);
        return $this;
    }

    public function route(string $route, RequestHandlerInterface $handler, string $method = 'GET'): AggregatedRoute
    {
        return $this->getRouter()->route($handler)
            ->pattern($route)
            ->method($method);
    }

    public function routePost(string $route, RequestHandlerInterface $handler): AggregatedRoute
    {
        return $this->getRouter()->post($route, $handler);
    }

    public function run()
    {
        /* @var $emitter SapiEmitter */
        $emitter = $this->getContainer()->get(SapiEmitter::class);
        $emitter->emit($this->handle($this->getRequest()));
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->handle($request);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->getContainer()->init($this);
        $this->pipe($this->getContainer()->get(ErrorMiddleware::class));
        $this->init();
        $this->pipe($this->getContainer()->get(CacheControlMiddleware::class));
        $this->pipe($this->getRouter());
        return $this->getPipeline()->handle($request);
    }

    public function override(ContainerResolver $resolver)
    {
    }

    public function getContainer(): ApplicationContainer
    {
        if (!isset($this->container)) {
            $this->container = ApplicationContainer::getInstance();
        }
        return $this->container;
    }

    private function getPipeline(): MiddlewarePipeline
    {
        if (!isset($this->pipeline)) {
            $this->pipeline = $this->getContainer()->get(
                MiddlewarePipeline::class,
                $this->getHandler()
            );
        }
        return $this->pipeline;
    }

    public function getRouter(): RequestRouter
    {
        if (!isset($this->router)) {
            $this->router = clone $this->getContainer()->get(RequestRouter::class);
        }
        return $this->router;
    }

    public function getConfig(): Config
    {
        if (!isset($this->config)) {
            $this->config = $this->getContainer()->get(Config::class);
        }
        return $this->config;
    }

    public function getHandler(): RequestHandlerInterface
    {
        if (!isset($this->handler)) {
            $this->handler = $this->getContainer()->get(NotFoundHandler::class);
        }
        return $this->handler;
    }

    public function getHttp(): HttpFactory
    {
        if (!isset($this->http)) {
            $this->http = $this->getContainer()->get(HttpFactory::class);
        }
        return $this->http;
    }

    public function getRequest(): ServerRequestInterface
    {
        if (!isset($this->request)) {
            $this->request = $this->getHttp()->createServerRequest();
        }
        return $this->request;
    }

    public function withHandler(RequestHandlerInterface $handler): self
    {
        $clone = clone $this;
        $clone->setHandler($handler);
        return $clone;
    }

    protected function setHandler(RequestHandlerInterface $handler): self
    {
        $this->handler = $handler;
        return $this;
    }
}
