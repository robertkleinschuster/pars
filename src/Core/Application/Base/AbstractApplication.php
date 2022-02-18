<?php

namespace Pars\Core\Application\Base;

use Locale;
use Pars\Core\Container\Container;
use Pars\Core\Emitter\SapiEmitter;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\Http\ServerRequest;
use Pars\Core\Middleware\NotFoundMiddleware;
use Pars\Core\Pipeline\MiddlewarePipeline;
use Pars\Core\Router\RequestRouter;
use Pars\Core\Session\SessionMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractApplication implements RequestHandlerInterface, MiddlewareInterface
{
    protected Container $container;
    protected MiddlewarePipeline $pipeline;
    protected RequestRouter $router;
    protected array $entrypoints = [];

    public function __construct(Container $container = null)
    {
        $this->container = $container ?? new Container();
        $this->router = $this->container->get(RequestRouter::class);
        $this->pipeline = $this->container->get(MiddlewarePipeline::class, $this);
        $this->pipeline->pipe($this->container->get(SessionMiddleware::class));
        $this->init();
        $this->loadEntrypoints();
        $this->pipeline->pipe($this->router);
        $this->pipeline->pipe($this->container->get(NotFoundMiddleware::class));
    }

    protected abstract function init();

    public function run()
    {
        /* @var $emitter SapiEmitter */
        $emitter = $this->container->get(SapiEmitter::class);
        $emitter->emit($this->pipeline->handle($this->container->get(ServerRequest::class)));
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->handle($request);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->container->get(NotFoundResponse::class);
    }

    protected function loadEntrypoints()
    {
        if (file_exists('public/static/entrypoints.json')) {
            $entrypoints = json_decode(file_get_contents('public/static/entrypoints.json'), true);
            if (is_array($entrypoints)) {
                $this->entrypoints = $entrypoints;
            }
        }
    }

    protected function addEntrypointHeader(ResponseInterface $response, string $entrypoint)
    {
        foreach ($this->entrypoints['entrypoints'][$entrypoint]['css'] ?? [] as $cssFile) {
            $response = $response->withAddedHeader('Link', "<$cssFile>; rel=\"preload\"; as=\"style\"");
        }
    }
}
