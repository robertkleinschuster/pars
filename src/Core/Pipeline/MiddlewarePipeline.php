<?php

namespace Pars\Core\Pipeline;

use Pars\Core\Middleware\BasePathMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->pipeline->isEmpty()) {
            return $this->handler->handle($request);
        }
        return $this->pipeline->shift()->process($request, $this);
    }

    public function pipe(MiddlewareInterface|string $middlewareOrPath, MiddlewareInterface $middleware = null): static
    {
        if (is_string($middlewareOrPath) && $middleware) {
            $this->pipeline->push(create(BasePathMiddleware::class, $middleware, $middlewareOrPath));
        } else {
            $this->pipeline->push($middlewareOrPath);
        }
        return $this;
    }
}
