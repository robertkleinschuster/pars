<?php
namespace Pars\Core\Application\Console\Build;

use JetBrains\PhpStorm\Pure;
use Pars\Core\Container\ContainerFactoryInterface;

class BuildEntrypointsFactory implements ContainerFactoryInterface
{
    #[Pure] public function create(array $params, string $id): object
    {
        return new BuildEntrypoints(...$params);
    }

}