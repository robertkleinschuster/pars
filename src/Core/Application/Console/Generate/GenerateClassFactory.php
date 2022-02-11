<?php

namespace Pars\Core\Application\Console\Generate;

use JetBrains\PhpStorm\Pure;
use Pars\Core\Container\ContainerFactoryInterface;

class GenerateClassFactory implements ContainerFactoryInterface
{
    #[Pure] public function create(array $params, string $id): object
    {
        return new GenerateClass(...$params);
    }

}