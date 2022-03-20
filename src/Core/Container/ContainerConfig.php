<?php

namespace Pars\Core\Container;

use Pars\Core\Config\ConfigFactory;
use Pars\Core\Config\Config;
use Pars\Core\Http\HttpFactory;
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
};

class ContainerConfig
{
    private Config $config;
    private array $factories;

    public function getFactories(): array
    {
        if (!isset($this->factories)) {
            $this->factories = $this->loadFactories();
        }
        return $this->factories;
    }

    protected function getDefaultFactories(): array
    {
        return [
            RequestFactoryInterface::class => HttpFactory::class,
            ResponseFactoryInterface::class => HttpFactory::class,
            ServerRequestFactoryInterface::class => HttpFactory::class,
            StreamFactoryInterface::class => HttpFactory::class,
            UploadedFileFactoryInterface::class => HttpFactory::class,
            UriFactoryInterface::class => HttpFactory::class,
            HttpFactory::class => HttpFactory::class,
            Config::class => ConfigFactory::class
        ];
    }

    private function loadFactories(): array
    {
        return array_replace_recursive($this->getDefaultFactories(), $this->getConfig()->get('factories', []));
    }

    private function getConfig(): Config
    {
        if (!isset($this->config)) {
            $this->config = new Config();
        }
        return $this->config;
    }
}
