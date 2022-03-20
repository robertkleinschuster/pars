<?php

namespace Pars\Core\Error;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\View\ViewRenderer;
use Psr\Container\ContainerInterface;

class ErrorMiddlewareFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id)
    {
        return new ErrorMiddleware($this->container->get(ViewRenderer::class));
    }
}
