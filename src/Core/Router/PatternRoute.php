<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;

class PatternRoute implements RouteInterface
{
    use ParentRouteTrait;

    private string $pattern;
    private array $attributes = [];

    /**
     * @param string $pattern
     */
    public function __construct(RouteInterface $route, string $pattern)
    {
        $this->route = $route;
        $this->pattern = $pattern;
    }


    public function match(ServerRequestInterface $request): void
    {
        if ($this->matchPattern($request)) {
            foreach ($this->attributes as $name => $value) {
                $request = $request->withAttribute($name, $value);
            }
            $this->matchChildRoute($request);
        }
    }

    private function matchPattern(ServerRequestInterface $request)
    {
        $path = $request->getUri()->getPath();
        $path = rtrim($path, '/');

        if ($path === rtrim($this->pattern, '/')) {
            return true;
        }

        if (str_ends_with($this->pattern, '+')) {
            $explodedRoute = explode('/', $this->pattern);
            $attributeName = ltrim(rtrim(array_pop($explodedRoute), '+'), ':');
            if (str_starts_with($path, implode('/', $explodedRoute))) {
                $explodedPath = explode('/', $path);
                foreach ($explodedRoute as $key => $part) {
                    unset($explodedPath[$key]);
                }
                $this->setAttribtue($attributeName, implode('/', $explodedPath));
                return true;
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
        $result = preg_match($pattern, $path, $ma);
        array_shift($ma);
        if (is_array($keys)) {
            foreach ($keys as $index => $key) {
                if (isset($ma[$index])) {
                    $this->setAttribtue(ltrim($key, ':'), $ma[$index]);
                }
            }
        }
        if ($result) {
            return true;
        }
        return false;
    }

    private function setAttribtue(string $name, string $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }
}