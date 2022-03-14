<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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

    public function match(ServerRequestInterface $request, ?array &$attributes): bool
    {
        if ($this->method && $this->method !== $request->getMethod()) {
            return false;
        }
        $path = $request->getUri()->getPath();
        $path = rtrim($path, '/');

        if ($path === rtrim($this->route, '/')) {
            return true;
        }

        $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($this->route)) . "$@D";

        preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $this->route, $m);
        array_walk_recursive($m, function ($a) use (&$keys) {
            $keys[] = $a;
        });

        $result = preg_match($pattern, $path, $ma);
        array_shift($ma);
        if (is_array($keys)) {
            foreach ($keys as $index => $key) {
                if (isset($ma[$index])) {
                    $attributes[ltrim($key, ':')] = $ma[$index];
                }
            }
        }
        return $result;
    }
}