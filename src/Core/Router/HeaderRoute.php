<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;

class HeaderRoute implements RouteInterface
{
    use ParentRouteTrait;

    private string $name;
    private string $value;

    public function __construct(RouteInterface $route, string $name, string $value)
    {
        $this->route = $route;
        $this->name = $name;
        $this->value = $value;
    }

    public function match(ServerRequestInterface $request): void
    {
        if ($this->matchHeader($request)) {
            $this->matchChildRoute($request);
        }
    }

    private function matchHeader(ServerRequestInterface $request)
    {
        return $request->getHeaderLine($this->name) === $this->value;
    }
}
