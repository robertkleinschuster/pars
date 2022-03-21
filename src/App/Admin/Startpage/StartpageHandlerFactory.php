<?php

namespace Pars\App\Admin\Startpage;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\View\ViewRenderer;
use Psr\Container\ContainerInterface;

class StartpageHandlerFactory implements ContainerFactoryInterface
{
    protected ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function create(string $id)
    {
        return new StartpageHandler($this->container->get(ViewRenderer::class));
    }
}
