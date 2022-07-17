<?php

namespace Pars\Core\View;

use Psr\Container\ContainerInterface;

class ViewComponentContainer implements ContainerInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(string $id): ViewComponent
    {
        if ($this->container->has($id)) {
            return $this->container->get($id);
        }
        if ($this->has($id)) {
            return new $id($this->container);
        }
        throw new ViewException("Could not find component '$id'");
    }

    public function has(string $id): bool
    {
        if (class_exists($id)) {
            return true;
        }
        return $this->container->has($id);
    }
}
