<?php
namespace Pars\Core\Container;
require_once "global.php";

use Psr\Container\ContainerInterface;
class Container implements ContainerInterface
{
    /**
     * @var ContainerFactoryInterface[]
     */
    protected array $factories = [];

    /**
     * @var array
     */
    protected array $services = [];

    /**
     * @var DefaultFactory
     */
    protected DefaultFactory $defaultFactory;

    public function __construct()
    {
        $this->defaultFactory = new DefaultFactory();
        $this->factories = include "config/factories.php";
        global $container;
        $container = $this;
    }

    /**
     * @param string $class
     * @param string $factory
     * @return void
     */
    public function register(string $class, string $factory) {
        $this->factories[$class] = $factory;
    }

    /**
     * @param string $className
     * @return ContainerFactoryInterface
     */
    protected function resolve(string $className): ContainerFactoryInterface
    {
        if (isset($this->factories[$className]) && is_string($this->factories[$className])) {
            $this->factories[$className] = new ($this->factories[$className]);
        }
        return $this->factories[$className] ?? $this->defaultFactory;
    }

    /**
     * @param string $id
     * @param mixed ...$params
     * @return mixed
     */
    public function create(string $id, ...$params): mixed
    {
        $factory = $this->resolve($id);
        return $factory->create($params, $id);
    }

    /**
     * @param string $id
     * @param mixed ...$params
     * @return mixed|object
     */
    public function get(string $id, ...$params): mixed
    {
        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->create($id, ...$params);
        }
        return $this->services[$id];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->factories[$id]) || $this->services[$id];
    }

}