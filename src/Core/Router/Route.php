<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function preg_match_all;
use function preg_quote;
use function preg_replace;
use function array_walk_recursive;
use function array_shift;
use function is_array;
use function rtrim;

class Route
{
    public RequestHandlerInterface $handler;
    public string $route;
    public ?string $method = null;

    public static function findKeys(string $route)
    {
        preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $route, $m);
        array_walk_recursive($m, function ($a) use (&$keys) {
            $keys[] = ltrim($a, ':');
        });
        return $keys ?? [];
    }

    public function __construct(RequestHandlerInterface $handler, string $route)
    {
        $this->handler = $handler;
        $this->route = $route;
    }

    public function getHandler(): RequestHandlerInterface
    {
        return $this->handler;
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

    public function match(ServerRequestInterface $request): ServerRequestInterface|bool
    {
        if ($this->method && $this->method !== $request->getMethod()) {
            return false;
        }
        $path = $request->getUri()->getPath();
        $path = rtrim($path, '/');

        if ($path === rtrim($this->route, '/')) {
            return $request->withAttribute(Route::class, $this);
        }

        if (str_ends_with($this->route, '+')) {
            $explodedRoute = explode('/', $this->route);
            $attributeName = ltrim(rtrim(array_pop($explodedRoute), '+'), ':');
            $explodedPath = explode('/', $path);
            foreach ($explodedRoute as $key => $part) {
                unset($explodedPath[$key]);
            }
            $request = $request->withAttribute($attributeName, implode('/', $explodedPath));
            return $request->withAttribute(Route::class, $this);
        }

        $pattern = "@^" . preg_replace(
            '/\\\:[a-zA-Z0-9\_\-]+/',
            '([a-zA-Z0-9\-\_]+)',
            preg_quote($this->route)
        ) . "$@D";

        preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $this->route, $m);
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
            return $request->withAttribute(Route::class, $this);
        }
        return false;
    }
}
