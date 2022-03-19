<?php

namespace Pars\App\Frontend;

use Pars\App\Frontend\Startpage\StartpageHandler;
use Pars\Core\Application\Web\WebApplication;

class FrontendApplication extends WebApplication
{
    protected function init()
    {
        parent::init();
        $this->route('/', $this->getContainer()->get(StartpageHandler::class));
    }
}
