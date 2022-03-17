<?php

use Pars\App\Admin\AdminApplication;
use Pars\App\Frontend\FrontendApplication;

return [
    '/admin' => AdminApplication::class,
    '/' => FrontendApplication::class,
];