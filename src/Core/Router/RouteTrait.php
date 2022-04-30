<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;

trait RouteTrait
{
    private ServerRequestInterface $matchedRequest;

    /**
     * @return ServerRequestInterface
     * @throws UnmatchedRouteException
     */
    public function getMatchedRequest(): ServerRequestInterface
    {
        if (!isset($this->matchedRequest)) {
            throw new UnmatchedRouteException('Route not matched in request');
        }
        return $this->matchedRequest;
    }

    public function isMatched(): bool
    {
        return isset($this->matchedRequest);
    }
}