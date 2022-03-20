<?php

namespace Pars\Core\Log;

use Pars\Core\Container\ContainerFactoryInterface;

class LogFactory implements ContainerFactoryInterface
{
    public function create(string $id): Log
    {
        return new Log();
    }
}
