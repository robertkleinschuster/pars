<?php

use Pars\Core\Console\Console;
use Pars\Core\Container\Container;

chdir(__DIR__);
require_once "vendor/autoload.php";
/* @var Console $console */
$console = Container::getInstance()->get(Console::class);
if ($argv[0] == 'console.php') {
    array_shift($argv);
}
$console->run($argv);
