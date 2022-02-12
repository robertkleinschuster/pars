<?php

namespace Pars\Core\Middleware;

use Pars\Core\Url\UrlBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function str_starts_with;

class PathMiddleware implements MiddlewareInterface
{
    protected MiddlewareInterface $middleware;
    protected string $path;

    public function __construct(MiddlewareInterface $middleware, string $path)
    {
        $this->middleware = $middleware;
        $this->path = $path;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (str_starts_with($request->getUri()->getPath(), $this->path)) {
            get(UrlBuilder::class)->addBaseUri(create(UriInterface::class, $this->path));
            $path = substr_replace($request->getUri()->getPath(), '', 0, strlen($this->path));
            return $this->middleware->process($request->withUri($request->getUri()->withPath($path)), $handler);
        }
        return $handler->handle($request);
    }

}