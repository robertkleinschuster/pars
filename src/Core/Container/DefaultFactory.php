<?php

namespace Pars\Core\Container;

use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface;
use Throwable;

class DefaultFactory implements ContainerFactoryInterface
{
    public function create(string $id, ...$params)
    {
        return new $id(...$params);
    }
}
