<?php

namespace Pars\Core\Error\NotFound;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class NotFoundHandlerFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id): NotFoundHandler
    {
        return new NotFoundHandler(
            $this->container->get(ResponseFactoryInterface::class),
            $this->container->get(StreamFactoryInterface::class),
            $this->container->get(ViewRenderer::class)
        );
    }
}
