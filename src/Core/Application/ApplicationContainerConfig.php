<?php

declare(strict_types=1);

namespace Pars\Core\Application;

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

class ApplicationContainerConfig
{
    protected array $providers = [
        \Mezzio\ConfigProvider::class,
        \Mezzio\Router\ConfigProvider::class,
        \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
        \Laminas\Diactoros\ConfigProvider::class,
        \Laminas\HttpHandlerRunner\ConfigProvider::class,
        ConfigProvider::class,
    ];

    public function toArray(): array
    {
        $config = (new ConfigAggregator($this->getProviders()))->getMergedConfig();
        $dependencies = $config['dependencies'];
        $dependencies['services'] = compact('config');
        return $dependencies;
    }

    protected function getProviders(): array
    {
        return $this->providers;
    }

    public function addProviderClass(string $providerClass): self
    {
        $this->providers[] = $providerClass;
        return $this;
    }

    public function addPhpFile(string $pattern): self
    {
        $this->providers[] = new PhpFileProvider($pattern);
        return $this;
    }

    public function addArray(array $config): self
    {
        $this->providers[] = new ArrayProvider($config);
        return $this;
    }
}
