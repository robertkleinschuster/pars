<?php

namespace Pars\Core\Middleware;

use Pars\Core\Url\UriBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function get;
use function str_starts_with;
use function strlen;

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
            /* @var $urlBuilder UriBuilder */
            $urlBuilder = get(UriBuilder::class);
            $urlBuilder->addBaseUri(http()->uriFactory()->createUri($this->path));
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
