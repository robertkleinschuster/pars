<?php

namespace Pars\Core\Application\Server\HandlerRunner;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\WebSocket\Server as SwooleWebSocketServer;
use Webmozart\Assert\Assert;

class SwooleRequestHandlerRunnerFactory
{
    public function __invoke(ContainerInterface $container): SwooleRequestHandlerRunner
    {
        $server = $container->get(SwooleWebSocketServer::class);
        Assert::isInstanceOf($server, SwooleWebSocketServer::class);

        $dispatcher = $container->get(\Mezzio\Swoole\Event\EventDispatcherInterface::class);
        Assert::isInstanceOf($dispatcher, EventDispatcherInterface::class);

        return new SwooleRequestHandlerRunner($server, $dispatcher);
    }
}