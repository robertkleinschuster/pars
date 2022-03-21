<?php

namespace Pars\Core\Application;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Container\Container;

/**
 * @method static $this getInstance()
 */
class ApplicationContainer extends Container
{
    public function init(AbstractApplication $application)
    {
        $application->override($this->getResolver());
        $changedServices = $this->getResolver()->reloadConfig();
        foreach ($changedServices as $changedService) {
            unset($this->services[$changedService]);
        }
    }
}
