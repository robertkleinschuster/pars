<?php

declare(strict_types=1);

namespace Pars\Core\Application;

use Laminas\Stratigility\MiddlewarePipeInterface;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\RouteCollector;
use Mezzio\Router\RouteCollectorInterface;
use Pars\Core\Application\Client\ClientMiddleware;
use Pars\Core\Application\Client\ClientMiddlewareFactory;
use Pars\Core\Application\Event\ApplicationEventDispatcher;
use Pars\Core\Application\Event\ApplicationEventDispatcherFactory;
use Pars\Core\Application\Event\ApplicationEventListenerProvider;
use Pars\Core\Application\Event\ApplicationEventListenerProviderFactory;
use Pars\Core\Application\Event\Message\ApplicationMessageEvent;
use Pars\Core\Application\Event\Message\ApplicationMessageListener;
use Pars\Core\Application\Event\Message\ApplicationMessageListenerFactory;
use Pars\Core\Application\Event\Open\ApplicationOpenEvent;
use Pars\Core\Application\Event\Open\ApplicationOpenListener;
use Pars\Core\Application\Event\Open\ApplicationOpenListenerFactory;
use Pars\Core\Application\Middleware\MiddlewareContainer;
use Pars\Core\Application\Middleware\MiddlewareContainerFactory;
use Pars\Core\Application\Middleware\MiddlewareFactoryFactory;
use Pars\Core\Application\Socket\WebSocketContainer;
use Pars\Core\Application\Socket\WebSocketContainerFactory;
use Pars\Core\Application\Socket\WebSocketMiddleware;
use Pars\Core\Application\Socket\WebSocketMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'application' => [
                'listeners' => [
                    ApplicationOpenEvent::class => [
                        ApplicationOpenListener::class
                    ],
                    ApplicationMessageEvent::class => [
                        ApplicationMessageListener::class
                    ],
                ]
            ]
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
                ApplicationEventListenerProvider::class => ApplicationEventListenerProviderFactory::class,
                ApplicationEventDispatcher::class => ApplicationEventDispatcherFactory::class,
                ApplicationOpenListener::class => ApplicationOpenListenerFactory::class,
                ApplicationMessageListener::class => ApplicationMessageListenerFactory::class,
                ClientMiddleware::class => ClientMiddlewareFactory::class,
                WebSocketContainer::class => WebSocketContainerFactory::class,
                WebSocketMiddleware::class => WebSocketMiddlewareFactory::class
            ]
        ];
    }
}
