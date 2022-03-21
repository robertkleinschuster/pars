<?php

use ParsTest\Core\Application\Bootstrap\MockFirstWebApplication;
use ParsTest\Core\Application\Bootstrap\MockSecondWebApplication;
use ParsTest\Core\Application\Bootstrap\MockThirdWebApplication;

return [
    '/first' => MockFirstWebApplication::class,
    '/second' => MockSecondWebApplication::class,
    '/' => MockThirdWebApplication::class,
];
