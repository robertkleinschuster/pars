<?php

use Pars\Core\Config\Config;
use Pars\Core\Http\Emitter\SapiEmitter;
use ParsTest\Core\Config\MockConfigFactory;
use ParsTest\Core\Container\MockContainer;
use ParsTest\Core\Http\Emitter\MockSapiEmitter;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";
$container = MockContainer::getInstance();
$container->getResolver()->overrideFactory(SapiEmitter::class, MockSapiEmitter::class);
$container->getResolver()->overrideFactory(Config::class, MockConfigFactory::class);