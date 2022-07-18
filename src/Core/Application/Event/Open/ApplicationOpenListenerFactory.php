<?php

namespace Pars\Core\Application\Event\Open;

use Pars\Core\Application\Socket\WebSocketContainer;
use Psr\Container\ContainerInterface;

class ApplicationOpenListenerFactory
{
    public function __invoke(ContainerInterface $container): ApplicationOpenListener
    {
        return new ApplicationOpenListener($container->get(WebSocketContainer::class));
    }
}