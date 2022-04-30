<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface RouteInterface
{
    public function match(ServerRequestInterface $request): void;
    public function isMatched(): bool;

    /**
     * @return ServerRequestInterface
     * @throws UnmatchedRouteException
     */
    public function getMatchedRequest(): ServerRequestInterface;
    public function getHandler(): RequestHandlerInterface;
}
