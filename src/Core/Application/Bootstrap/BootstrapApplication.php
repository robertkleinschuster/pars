<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;

class BootstrapApplication extends AbstractApplication
{
    protected function init()
    {
        $apps = require_once 'config/apps.php';
        foreach ($apps as $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->container->get($appClass);
            if ($app instanceof PathApplicationInterface) {
                $this->pipeline->pipe($app->getPath(), $app);
            } else {
                $this->pipeline->pipe($app);
            }
        }
    }
}