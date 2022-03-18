<?php

namespace Pars\App\Frontend;

use Pars\App\Frontend\Startpage\StartpageHandler;
use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Middleware\NotFoundMiddleware;

class FrontendApplication extends WebApplication
{
    protected function init()
    {
        $this->route('/', $this->getContainer()->get(StartpageHandler::class));
    }
}
