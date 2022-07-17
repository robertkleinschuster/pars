<?php

namespace Pars\Core\Http\Uri;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\UriFactoryInterface;

class UriBuilderFactory
{
    public function __invoke(ContainerInterface $container): UriBuilder
    {
        return new UriBuilder($container->get(UriFactoryInterface::class));
    }
}
