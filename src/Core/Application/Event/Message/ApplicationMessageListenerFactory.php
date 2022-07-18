<?php

namespace Pars\Core\Application\Event\Message;

use Pars\Core\Application\Socket\WebSocketContainer;
use Psr\Container\ContainerInterface;

class ApplicationMessageListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ApplicationMessageListener($container->get(WebSocketContainer::class));
    }
}