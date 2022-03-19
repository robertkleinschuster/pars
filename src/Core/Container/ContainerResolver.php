<?php

namespace Pars\Core\Container;

class ContainerResolver
{
    /**
     * @var ContainerFactoryInterface[]
     */
    private array $factories = [];
    private ContainerConfig $config;
    private DefaultFactory $defaultFactory;
    private Container $container;

    /**
     * @param Container $container
     */
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
            return $this->factories[$id] = new ($factories[$id])($this->container);
        }
        // no factory found
        return $this->getDefaultFactory();
    }

    protected function getDefaultFactory(): DefaultFactory
    {
        if (!isset($this->defaultFactory)) {
            $this->defaultFactory = new DefaultFactory();
        }
        return $this->defaultFactory;
    }
}
