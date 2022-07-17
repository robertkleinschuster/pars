<?php

namespace Pars\Core\Application\Middleware;

use Psr\Container\ContainerInterface;

class MiddlewareContainerFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareContainer
    {
        return new MiddlewareContainer($container);
    }
}