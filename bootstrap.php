<?php

use Pars\Core\Application\Bootstrap\BootstrapApplication;

chdir(__DIR__);
require_once "vendor/autoload.php";
$app = new BootstrapApplication();
$app->run();