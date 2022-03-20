<?php

use Pars\App\Admin\AdminApplication;
use Pars\App\Site\SiteApplication;

return [
    '/admin' => AdminApplication::class,
    '/' => SiteApplication::class,
];
