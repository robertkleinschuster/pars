<?php

namespace Pars\Core\Application\Server\Event;

use Psr\Container\ContainerInterface;

class MessageListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MessageListener();
    }
}