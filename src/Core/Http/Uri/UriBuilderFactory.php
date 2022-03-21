<?php

namespace Pars\Core\Http\Uri;

use Pars\Core\Container\ContainerFactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\UriFactoryInterface;

class UriBuilderFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id): UriBuilder
    {
        return new UriBuilder($this->container->get(UriFactoryInterface::class));
    }
}
