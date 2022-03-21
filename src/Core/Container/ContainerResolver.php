<?php

namespace Pars\Core\Container;

use Pars\Core\Config\Config;

class ContainerResolver
{
    /**
     * @var ContainerFactoryInterface[]
     */
    private array $factories = [];
    private ContainerConfig $config;
    private DefaultFactory $defaultFactory;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerConfig
     */
    protected function getConfig(): ContainerConfig
    {
        if (!isset($this->config)) {
            $this->config = new ContainerConfig();
        }
        return $this->config;
    }

    public function hasFactory(string $id): bool
    {
        $factories = $this->getConfig()->getFactories();
        return isset($factories[$id]);
    }


    public function resolveFactory(string $id): ContainerFactoryInterface
    {
        // has cached factory instance
        if (isset($this->factories[$id])) {
            return $this->factories[$id];
        }
        // has factory class in config
        $factories = $this->getConfig()->getFactories();
        if (isset($factories[$id]) && is_string($factories[$id])) {
            // cache and return factory instance
            return $this->factories[$id] = $this->createFactory($factories[$id]);
        }
        // no factory found
        return $this->getDefaultFactory();
    }

    private function createFactory(string $factoryClass): ContainerFactoryInterface
    {
        return new $factoryClass($this->container);
    }

    public function overrideFactory(string $id, string $factoryClass): ContainerResolver
    {
        $this->factories[$id] = $this->createFactory($factoryClass);
        return $this;
    }

    public function reloadConfig(): array
    {
        $previousServices = $this->config->getServices();
        $this->config = new ContainerConfig($this->container->create(Config::class));
        $changedServices = array_diff($this->config->getServices(), $previousServices);
        $changedServices[] = Config::class;
        return $changedServices;
    }

    protected function getDefaultFactory(): DefaultFactory
    {
        if (!isset($this->defaultFactory)) {
            $this->defaultFactory = new DefaultFactory();
        }
        return $this->defaultFactory;
    }
}
