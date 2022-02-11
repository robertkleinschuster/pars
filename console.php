<?php

use Pars\Core\Application\Console\ConsoleApplication;

chdir(__DIR__);
require_once "vendor/autoload.php";
$app = new ConsoleApplication();
if ($argv[0] == 'console.php') {
    array_shift($argv);
}
$app->run($argv);