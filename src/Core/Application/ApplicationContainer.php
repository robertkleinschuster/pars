<?php

namespace Pars\Core\Application;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Container\Container;

class ApplicationContainer extends Container
{
    public function init(AbstractApplication $application)
    {
        $application->override($this->resolver);
        $changedServices = $this->resolver->reloadConfig();
        foreach ($changedServices as $changedService) {
            unset($this->services[$changedService]);
        }
    }
}
