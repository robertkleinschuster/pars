<?php

namespace Pars\Core\Container;

use Pars\Core\Config\Config;
use Pars\Core\Http\{ClosureResponse,
    HtmlResponse,
    HttpFactory,
    NotFoundResponse,
    RedirectResponse,
    ServerRequest,
    ServerRequestFactory
};
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ResponseInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    StreamInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
    UriInterface
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
            UriFactoryInterface::class => HttpFactory::class,
            ServerRequestFactoryInterface::class => HttpFactory::class,
            RequestFactoryInterface::class => HttpFactory::class,
            ResponseFactoryInterface::class => HttpFactory::class,
            StreamFactoryInterface::class => HttpFactory::class,
            UploadedFileFactoryInterface::class => HttpFactory::class,
            ServerRequest::class => ServerRequestFactory::class,
            NotFoundResponse::class => HttpFactory::class,
            ClosureResponse::class => HttpFactory::class,
            UriInterface::class => HttpFactory::class,
            HtmlResponse::class => HttpFactory::class,
            RedirectResponse::class => HttpFactory::class,
            ResponseInterface::class => HttpFactory::class,
            StreamInterface::class => HttpFactory::class
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
