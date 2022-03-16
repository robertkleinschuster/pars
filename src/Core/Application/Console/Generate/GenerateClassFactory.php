<?php

namespace Pars\Core\Application\Console\Generate;

use Pars\Core\Container\ContainerFactoryInterface;

class GenerateClassFactory implements ContainerFactoryInterface
{
    public function create(array $params, string $id): object
    {
        return new GenerateClass(...$params);
    }
}
