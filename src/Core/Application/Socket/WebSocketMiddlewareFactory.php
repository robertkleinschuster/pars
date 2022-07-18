<?php

namespace Pars\Core\Application\Socket;

use Psr\Container\ContainerInterface;

class WebSocketMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new WebSocketMiddleware($container->get(WebSocketContainer::class));
    }
}