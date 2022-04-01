<?php

namespace Pars\Core\Router;

use Pars\Core\Container\ContainerFactoryInterface;
use Pars\Core\Http\Uri\UriBuilder;
use Psr\Container\ContainerInterface;

class RequestRouterFactory implements ContainerFactoryInterface
{
    protected ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $id): RequestRouter
    {
        return new RequestRouter(
            $this->container->get(RouteFactory::class),
            $this->container->get(UriBuilder::class)
        );
    }
}
