<?php
namespace Pars\Core\Application\Base;

use Pars\Core\Container\Container;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\Http\ServerRequest;
use Pars\Core\Pipeline\MiddlewarePipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractApplication implements RequestHandlerInterface, MiddlewareInterface
{
    protected Container $container;
    protected MiddlewarePipeline $pipeline;

    public function __construct()
    {
        $this->container = new Container();
        $this->pipeline = $this->container->get(MiddlewarePipeline::class, $this);
        $this->init();
    }

    protected function init()
    {

    }

    public function run()
    {
        $request = $this->container->get(ServerRequest::class);
        $response = $this->pipeline->handle($request);
        http_response_code($response->getStatusCode());
        echo $response->getBody()->getContents();
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