<?php

use Pars\Core\Config\Config;
use Pars\Core\Emitter\SapiEmitter;
use ParsTest\Core\Config\MockConfig;
use ParsTest\Core\Container\MockContainer;
use ParsTest\Core\Emitter\MockSapiEmitter;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";
$container = MockContainer::getInstance();
$container->register(SapiEmitter::class, MockSapiEmitter::class);
$container->register(Config::class, MockConfig::class);
