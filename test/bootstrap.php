<?php

use Pars\Core\Container\Container;
use Pars\Core\Emitter\SapiEmitter;
use ParsTest\Core\Emitter\MockSapiEmitter;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";
$container = Container::getInstance();
$container->register(SapiEmitter::class, MockSapiEmitter::class);
