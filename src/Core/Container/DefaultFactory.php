<?php

namespace Pars\Core\Container;

use JetBrains\PhpStorm\Pure;
use Throwable;

class DefaultFactory implements ContainerFactoryInterface
{
    /**
     * @throws Throwable
     */
    public function create(array $params, string $id): mixed
    {
        return new $id(...$params);
    }
}
