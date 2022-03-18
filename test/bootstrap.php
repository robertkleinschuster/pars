<?php

use ParsTest\Core\Container\MockContainer;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";
$container = MockContainer::getInstance();
