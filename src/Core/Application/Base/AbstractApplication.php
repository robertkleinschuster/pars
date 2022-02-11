<?php
namespace Pars\Core\Application\Base;

use Pars\Core\Container\Container;
use Pars\Core\Emitter\SapiEmitter;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\Http\ServerRequest;
use Pars\Core\Middleware\NotFoundMiddleware;
use Pars\Core\Pipeline\MiddlewarePipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractApplication implements RequestHandlerInterface, MiddlewareInterface
{
    protected Container $container;
    protected MiddlewarePipeline $pipeline;

    public function __construct(Container $container = null)
    {
        $this->container = $container ?? new Container();
        $this->pipeline = $this->container->get(MiddlewarePipeline::class, $this);
        $this->init();
        $this->pipeline->pipe($this->container->get(NotFoundMiddleware::class));
    }

    protected abstract function init();

    public function run()
    {
        /* @var $emitter SapiEmitter */
        $emitter = $this->container->get(SapiEmitter::class);
        $emitter->emit($this->pipeline->handle($this->container->get(ServerRequest::class)));
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->container->get(NotFoundResponse::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->handle($request);
    }
}