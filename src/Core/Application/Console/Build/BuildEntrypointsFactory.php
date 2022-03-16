<?php

namespace Pars\Core\Application\Console\Build;

use Pars\Core\Container\ContainerFactoryInterface;

class BuildEntrypointsFactory implements ContainerFactoryInterface
{
    public function create(array $params, string $id): object
    {
        return new BuildEntrypoints(...$params);
    }
}
