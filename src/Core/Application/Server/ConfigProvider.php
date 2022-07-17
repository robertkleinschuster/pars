<?php

declare(strict_types=1);

namespace Pars\Core\Application\Server;

use Mezzio\Swoole\Event\HotCodeReloaderWorkerStartListener;
use Mezzio\Swoole\Event\WorkerStartEvent;
use Pars\Core\Application\Host\HostRouteMiddleware;
use Pars\Core\Application\Host\HostRouteMiddlewareFactory;

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
                'paths'    => [
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
                    ]
                ]
            ],
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                HostRouteMiddleware::class => HostRouteMiddlewareFactory::class
            ]
        ];
    }
}
