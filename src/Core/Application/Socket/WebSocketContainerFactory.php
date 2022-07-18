<?php

namespace Pars\Core\Application\Socket;

class WebSocketContainerFactory
{
    public function __invoke(): WebSocketContainer
    {
        return new WebSocketContainer();
    }
}