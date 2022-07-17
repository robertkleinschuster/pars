<?php

namespace Pars\Core\View\Group;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ViewGroupHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ViewGroupHandler($container->get(ResponseFactoryInterface::class));
    }
}