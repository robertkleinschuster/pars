<?php

namespace Pars\Core\Pipeline;

use Pars\Core\Pipeline\BasePath\BasePathMiddlewareFactory;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use SplStack;

use function is_string;

class MiddlewarePipeline implements RequestHandlerInterface
{
    protected SplStack $pipeline;
    protected RequestHandlerInterface $handler;
    protected BasePathMiddlewareFactory $basePathFactory;

    public function __construct(RequestHandlerInterface $handler, BasePathMiddlewareFactory $basePathFactory)
    {
        $this->pipeline = new SplStack();
        $this->handler = $handler;
        $this->basePathFactory = $basePathFactory;
    }

    public function __clone()
    {
        $this->pipeline = clone $this->pipeline;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->pipeline->isEmpty()) {
            return $this->handler->handle($request);
        }
        return $this->pipeline->shift()->process($request, $this);
    }

    public function with(MiddlewareInterface|string $middlewareOrPath, MiddlewareInterface $middleware = null): static
    {
        $clone = clone $this;
        if (is_string($middlewareOrPath) && $middleware) {
            $middlewareOrPath = $this->basePathFactory->createBasePathMiddleware($middleware, $middlewareOrPath);
        }
        $clone->pipeline->push($middlewareOrPath);
        return $clone;
    }
}
