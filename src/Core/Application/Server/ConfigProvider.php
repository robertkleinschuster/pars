<?php

declare(strict_types=1);

namespace Pars\Core\Application\Server;

use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Mezzio\Swoole\Event\HotCodeReloaderWorkerStartListener;
use Mezzio\Swoole\Event\WorkerStartEvent;
use Pars\Core\Application\Host\HostRouteMiddleware;
use Pars\Core\Application\Host\HostRouteMiddlewareFactory;
use Pars\Core\Application\Server\Event\MessageEvent;
use Pars\Core\Application\Server\Event\MessageListener;
use Pars\Core\Application\Server\Event\MessageListenerFactory;
use Pars\Core\Application\Server\HandlerRunner\SwooleRequestHandlerRunner;
use Pars\Core\Application\Server\HandlerRunner\SwooleRequestHandlerRunnerFactory;
use Pars\Core\Application\Server\Swoole\WebSocketServerFactory;
use Swoole\WebSocket\Server as SwooleWebSocketServer;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'mezzio-swoole' => $this->getSwoole(),
            'dependencies' => $this->getDependencies()
        ];
    }

    private function getSwoole(): array
    {
        return [
            'hot-code-reload' => [
                'interval' => 500,
                'paths' => [
                    getcwd(),
                ],
            ],
            'swoole-http-server' => [
                'host' => '0.0.0.0',
                'port' => 8080,
                'static-files' => [
                    'gzip' => [
                        'level' => 0
                    ]
                ],
                'listeners' => [
                    WorkerStartEvent::class => [
                        HotCodeReloaderWorkerStartListener::class,
                    ],
                    MessageEvent::class => [
                        MessageListener::class
                    ]
                ]
            ],
        ];
    }

    private function getDependencies(): array
    {
        return [
            'aliases' => [
                RequestHandlerRunnerInterface::class => SwooleRequestHandlerRunner::class
            ],
            'factories' => [
                HostRouteMiddleware::class => HostRouteMiddlewareFactory::class,
                SwooleRequestHandlerRunner::class => SwooleRequestHandlerRunnerFactory::class,
                SwooleWebSocketServer::class => WebSocketServerFactory::class,
                MessageListener::class => MessageListenerFactory::class
            ]
        ];
    }
}
