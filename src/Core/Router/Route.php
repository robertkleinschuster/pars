<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_shift;
use function array_walk_recursive;
use function is_array;
use function preg_match_all;
use function preg_quote;
use function preg_replace;
use function rtrim;

class Route implements RouteInterface
{
    private RequestHandlerInterface $handler;
    private ServerRequestInterface $matchedRequest;

    public string $pattern;

    public ?string $method = null;


    public static function findKeys(string $route)
    {
        preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $route, $m);
        array_walk_recursive($m, function ($a) use (&$keys) {
            $keys[] = ltrim($a, ':');
        });
        return $keys ?? [];
    }

    public function __construct(RequestHandlerInterface $handler, string $pattern)
    {
        $this->handler = $handler;
        $this->pattern = $pattern;
    }

    public function getHandler(): RequestHandlerInterface
    {
        return $this->handler;
    }

    public function isMatched(): bool
    {
        return isset($this->matchedRequest);
    }

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

    public function match(ServerRequestInterface $request): void
    {
        if ($this->method && $this->method !== $request->getMethod()) {
            return;
        }
        $path = $request->getUri()->getPath();
        $path = rtrim($path, '/');

        if ($path === rtrim($this->pattern, '/')) {
            $this->matchedRequest = $request->withAttribute(Route::class, $this);
            return;
        }

        if (str_ends_with($this->pattern, '+')) {
            $explodedRoute = explode('/', $this->pattern);
            $attributeName = ltrim(rtrim(array_pop($explodedRoute), '+'), ':');
            if (str_starts_with($path, implode('/', $explodedRoute))) {
                $explodedPath = explode('/', $path);
                foreach ($explodedRoute as $key => $part) {
                    unset($explodedPath[$key]);
                }
                $request = $request->withAttribute($attributeName, implode('/', $explodedPath));
                $this->matchedRequest = $request->withAttribute(Route::class, $this);
                return;
            }
        }

        $pattern = "@^" . preg_replace(
                '/\\\:[a-zA-Z0-9\_\-]+/',
                '([a-zA-Z0-9\-\_]+)',
                preg_quote($this->pattern)
            ) . "$@D";

        preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $this->pattern, $m);
        array_walk_recursive($m, function ($a) use (&$keys) {
            $keys[] = $a;
        });
        $attributes = [];
        $result = preg_match($pattern, $path, $ma);
        array_shift($ma);
        if (is_array($keys)) {
            foreach ($keys as $index => $key) {
                if (isset($ma[$index])) {
                    $attributes[ltrim($key, ':')] = $ma[$index];
                }
            }
        }
        foreach ($attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        if ($result) {
            $this->matchedRequest = $request->withAttribute(Route::class, $this);
        }
    }

    /**
     * @param string|null $method
     * @return Route
     */
    public function setMethod(?string $method): Route
    {
        $this->method = $method;
        return $this;
    }
}
