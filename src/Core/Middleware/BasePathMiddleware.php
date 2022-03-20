<?php

namespace Pars\Core\Middleware;

use Pars\Core\Url\UriBuilder;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface, UriFactoryInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

use function str_starts_with;
use function strlen;
use function substr;

class BasePathMiddleware implements MiddlewareInterface
{
    protected UriBuilder $uriBuilder;
    protected UriFactoryInterface $uriFactory;
    protected MiddlewareInterface $middleware;
    protected string $path;

    public function __construct(
        UriBuilder $uriBuilder,
        UriFactoryInterface $uriFactory,
        MiddlewareInterface $middleware,
        string $path
    ) {
        $this->uriBuilder = $uriBuilder;
        $this->uriFactory = $uriFactory;
        $this->middleware = $middleware;
        $this->path = $path;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (str_starts_with($request->getUri()->getPath(), $this->path)) {
            $this->uriBuilder->addBaseUri($this->uriFactory->createUri($this->path));
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
