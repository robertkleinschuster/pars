<?php

namespace Pars\App\Admin;

use Pars\Core\Config\Config;
use Pars\Core\Config\ConfigFactory;
use Psr\Container\ContainerInterface;

class AdminConfigFactory extends ConfigFactory
{
    public function __construct(ContainerInterface $container, $prev = null)
    {
        if ($prev) {
            echo "<pre>";
            var_dump($prev);
            echo "</pre>";
            exit;
        }
    }


    public function create(string $id): Config
    {
        return new Config(null, ['admin', 'development']);
    }
}
