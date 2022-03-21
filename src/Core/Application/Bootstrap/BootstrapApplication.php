<?php

namespace Pars\Core\Application\Bootstrap;

use Pars\Core\Application\Base\AbstractApplication;

class BootstrapApplication extends AbstractApplication
{
    protected function init()
    {
        foreach ($this->getApps() as $path => $appClass) {
            /* @var $app AbstractApplication */
            $app = $this->getContainer()->get($appClass);
            if (is_string($path)) {
                $this->pipe($path, $app);
            } else {
                $this->pipe($app);
            }
        }
    }

    protected function getApps(): array
    {
        return $this->getConfig()->get('apps', []);
    }
}
