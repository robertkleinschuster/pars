<?php

namespace Pars\Core\Application\Event;

use Psr\Container\ContainerInterface;

class ApplicationEventDispatcherFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ApplicationEventDispatcher($container->get(ApplicationEventListenerProvider::class));
    }
}