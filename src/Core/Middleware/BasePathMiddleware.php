<?php

namespace Pars\Core\Middleware;

use Pars\Core\Url\UrlBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function str_starts_with;
use function substr_replace;
use function strlen;
use function get;
use function create;

class BasePathMiddleware implements MiddlewareInterface
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
            /* @var $urlBuilder UrlBuilder */
            $urlBuilder = get(UrlBuilder::class);
            $urlBuilder->addBaseUri(create(UriInterface::class, $this->path));
            if ($this->path === '/') {
                $path = $request->getUri()->getPath();
            } else {
                $path = substr($request->getUri()->getPath(), strlen($this->path));
            }
            return $this->middleware->process($request->withUri($request->getUri()->withPath($path)), $handler);
        }
        return $handler->handle($request);
    }

}
