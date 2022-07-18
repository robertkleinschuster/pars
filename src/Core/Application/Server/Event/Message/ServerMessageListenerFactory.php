<?php

namespace Pars\Core\Application\Server\Event\Message;

use Pars\Core\Application\Middleware\MiddlewareContainer;
use Psr\Container\ContainerInterface;

class ServerMessageListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ServerMessageListener($container->get(MiddlewareContainer::class));
    }
}