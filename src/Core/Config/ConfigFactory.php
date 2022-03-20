<?php

namespace Pars\Core\Config;

use Pars\Core\Container\ContainerFactoryInterface;

class ConfigFactory implements ContainerFactoryInterface
{
    public function create(string $id): Config
    {
        return new Config();
    }
}
