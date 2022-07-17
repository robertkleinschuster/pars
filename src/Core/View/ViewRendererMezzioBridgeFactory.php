<?php

namespace Pars\Core\View;

use Psr\Container\ContainerInterface;

class ViewRendererMezzioBridgeFactory
{
    public function __invoke(ContainerInterface $container): ViewRendererMezzioBridge
    {
        return new ViewRendererMezzioBridge(
            $container->get(ViewComponentContainer::class),
            $container->get(ViewRenderer::class)
        );
    }
}