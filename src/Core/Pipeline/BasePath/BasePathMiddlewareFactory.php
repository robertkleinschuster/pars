<?php

namespace Pars\Core\Pipeline\BasePath;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Http\Uri\UriBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\UriFactoryInterface;

class BasePathMiddlewareFactory implements ContainerFactoryInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function getUriBuilder(): UriBuilder
    {
        return $this->container->get(UriBuilder::class);
    }

    private function getUriFactory(): UriFactoryInterface
    {
        return $this->container->get(UriFactoryInterface::class);
    }

    public function create(string $id, ...$params): BasePathMiddleware
    {
        $uriBuilder = $this->getUriBuilder();
        $uriFactory = $this->getUriFactory();
        return new BasePathMiddleware(
            $uriBuilder,
            $uriFactory,
            $params[0],
            $params[1]
        );
    }
}
