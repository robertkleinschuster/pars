<?php

namespace Pars\Core\View;

use Psr\Container\ContainerInterface;

class ViewRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ViewRenderer();
    }
}