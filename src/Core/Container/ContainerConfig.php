<?php

namespace Pars\Core\Container;

use Pars\Core\Config\{Config, ConfigFactory};
use Pars\Core\Http\HttpFactory;
use Pars\Core\Log\{Log, LogFactory};
use Pars\Core\Pipeline\BasePath\{BasePathMiddleware, BasePathMiddlewareFactory};
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Http\Uri\UriBuilderFactory;
use Pars\Core\Pipeline\MiddlewarePipeline;
use Pars\Core\Pipeline\MiddlewarePipelineFactory;
use Pars\Core\Router\RequestRouter;
use Pars\Core\Router\RequestRouterFactory;
use Pars\Core\View\Editor\FileEditorHandler;
use Pars\Core\View\Editor\FileEditorHandlerFactory;
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
};
use Psr\Log\LoggerInterface;

class ContainerConfig
{
    private Config $config;
    private array $factories;

    public function __construct(Config $config = null)
    {
        if (null !== $config) {
            $this->config = $config;
        }
    }

    public function getFactories(): array
    {
        if (!isset($this->factories)) {
            $this->factories = $this->loadFactories();
        }
        return $this->factories;
    }

    public function getServices(): array
    {
        return array_keys($this->getFactories());
    }

    protected function getDefaultFactories(): array
    {
        return [
            Log::class => LogFactory::class,
            LoggerInterface::class => LogFactory::class,
            Config::class => ConfigFactory::class,
            UriBuilder::class => UriBuilderFactory::class,
            RequestFactoryInterface::class => HttpFactory::class,
            ResponseFactoryInterface::class => HttpFactory::class,
            ServerRequestFactoryInterface::class => HttpFactory::class,
            StreamFactoryInterface::class => HttpFactory::class,
            UploadedFileFactoryInterface::class => HttpFactory::class,
            UriFactoryInterface::class => HttpFactory::class,
            HttpFactory::class => HttpFactory::class,
            RequestRouter::class => RequestRouterFactory::class,
            MiddlewarePipeline::class => MiddlewarePipelineFactory::class,
            BasePathMiddleware::class => BasePathMiddlewareFactory::class,
            FileEditorHandler::class => FileEditorHandlerFactory::class,
        ];
    }

    private function loadFactories(): array
    {
        return array_replace_recursive(
            $this->getDefaultFactories(),
            $this->getConfig()->get('factories', [])
        );
    }

    private function getConfig(): Config
    {
        if (!isset($this->config)) {
            $this->config = new Config();
        }
        return $this->config;
    }
}
