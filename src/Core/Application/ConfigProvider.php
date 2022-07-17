<?php

declare(strict_types=1);

namespace Pars\Core\Application;

use Laminas\Stratigility\MiddlewarePipeInterface;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\RouteCollector;
use Mezzio\Router\RouteCollectorInterface;
use Pars\Core\Application\Middleware\MiddlewareContainer;
use Pars\Core\Application\Middleware\MiddlewareContainerFactory;
use Pars\Core\Application\Middleware\MiddlewareFactoryFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'aliases' => [
                MiddlewarePipeInterface::class => 'Mezzio\\ApplicationPipeline',
                RouteCollectorInterface::class => RouteCollector::class,
            ],
            'factories' => [
                MiddlewareContainer::class => MiddlewareContainerFactory::class,
                MiddlewareFactory::class => MiddlewareFactoryFactory::class,
            ]
        ];
    }
}
