<?php

namespace Pars\Core\Pipeline;

use Pars\Core\Pipeline\BasePath\BasePathMiddleware;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use SplStack;

use function is_string;

class MiddlewarePipeline implements RequestHandlerInterface
{
    protected SplStack $pipeline;
    protected RequestHandlerInterface $handler;

    public function __construct(RequestHandlerInterface $handler)
    {
        $this->pipeline = new SplStack();
        $this->handler = $handler;
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
            $clone->pipeline->push(create(BasePathMiddleware::class, $middleware, $middlewareOrPath));
        } else {
            $clone->pipeline->push($middlewareOrPath);
        }
        return $clone;
    }
}
