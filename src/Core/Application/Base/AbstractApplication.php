<?php

namespace Pars\Core\Application\Base;

use Pars\Core\{Config\Config,
    Container\Container,
    Emitter\SapiEmitter,
    Http\HttpFactory,
    NotFound\NotFoundHandler,
    Pipeline\MiddlewarePipeline,
    Router\RequestRouter
};
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

abstract class AbstractApplication implements RequestHandlerInterface, MiddlewareInterface
{
    private Container $container;
    private MiddlewarePipeline $pipeline;
    private RequestRouter $router;
    private Config $config;
    private RequestHandlerInterface $handler;
    private HttpFactory $http;
    private ServerRequestInterface $request;

    public function __construct(Container $container = null)
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

    protected function initPipeline()
    {
        $this->init();
        $this->pipe($this->getRouter());
    }

    public function pipe(MiddlewareInterface|string $middlewareOrPath, MiddlewareInterface $middleware = null): self
    {
        $this->pipeline = $this->getPipeline()->with($middlewareOrPath, $middleware);
        return $this;
    }

    public function route(string $route, RequestHandlerInterface $handler): self
    {
        $this->router = $this->getRouter()->with($route, $handler);
        return $this;
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
        $this->initPipeline();
        return $this->getPipeline()->handle($request);
    }

    public function getContainer(): Container
    {
        if (!isset($this->container)) {
            $this->container = Container::getInstance();
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

    private function getRouter(): RequestRouter
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
