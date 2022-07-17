<?php

namespace Pars\Core\View;

use Psr\Container\ContainerInterface;

class ViewComponentContainerFactory
{
    public function __invoke(ContainerInterface $container): ViewComponentContainer
    {
        return new ViewComponentContainer($container);
    }
}