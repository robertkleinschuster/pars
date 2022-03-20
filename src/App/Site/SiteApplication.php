<?php

namespace Pars\App\Site;

use Pars\App\Site\Startpage\StartpageHandler;
use Pars\Core\Application\Web\WebApplication;

class SiteApplication extends WebApplication
{
    protected function init()
    {
        parent::init();
        $this->route('/', $this->getContainer()->get(StartpageHandler::class));
    }
}
