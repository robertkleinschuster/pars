<?php

namespace Pars\Core\View\Editor;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\View\ViewRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class FileEditorHandlerFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id): FileEditorHandler
    {
        return new FileEditorHandler(
            clone $this->container->get(ViewRenderer::class),
            $this->container->get(StreamFactoryInterface::class),
            $this->container->get(ResponseFactoryInterface::class)
        );
    }
}
