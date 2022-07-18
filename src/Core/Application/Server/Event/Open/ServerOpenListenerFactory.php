<?php

namespace Pars\Core\Application\Server\Event\Open;

use Pars\Core\Application\Middleware\MiddlewareContainer;
use Psr\Container\ContainerInterface;

class ServerOpenListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ServerOpenListener($container->get(MiddlewareContainer::class));
    }
}