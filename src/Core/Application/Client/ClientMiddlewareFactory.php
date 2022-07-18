<?php

namespace Pars\Core\Application\Client;

use Psr\Container\ContainerInterface;

class ClientMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ClientMiddleware();
    }
}