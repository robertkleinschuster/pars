<?php

namespace Pars\Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AggregatedRoute implements RouteInterface
{
    use ParentRouteTrait;

    private RouteFactory $factory;

    public function __construct(RequestHandlerInterface $handler)
    {
        $this->factory = new RouteFactory();
        $this->route = $this->factory->createAny($handler);
    }

    public function match(ServerRequestInterface $request): void
    {
        $this->matchChildRoute($request);
    }

    public function pattern(string $pattern): self
    {
        $this->route = $this->factory->createPattern($this->route, $pattern);
        return $this;
    }

    public function method(string $method): self
    {
        $this->route = $this->factory->createMethod($this->route, $method);
        return $this;
    }

    public function header(string $name, string $value): self
    {
        $this->route = $this->factory->createHeader($this->route, $name, $value);
        return $this;
    }
}
