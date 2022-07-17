#!/usr/bin/env php
<?php

declare(strict_types=1);

use Pars\App\Test\TestApplication;
use Pars\Core\Application\Server\ServerApplication;
use Pars\Core\Translator\Translator;

chdir(__DIR__);
require_once "vendor/autoload.php";

$app = new ServerApplication(
    [
        'admin' => \Pars\App\Admin\AdminApplication::class,
        'test' => TestApplication::class,
    ],
    getenv('DEV_DOMAIN')
);
$app->run();
