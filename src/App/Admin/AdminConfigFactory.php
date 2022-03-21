<?php

namespace Pars\App\Admin;

use Pars\Core\Config\Config;
use Pars\Core\Config\ConfigFactory;

class AdminConfigFactory extends ConfigFactory
{
    public function create(string $id): Config
    {
        return new Config(null, ['admin', 'development']);
    }
}
