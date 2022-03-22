<?php

namespace Pars\Core\Util\Phpinfo;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Phpinfo extends ViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        ob_start();
        phpinfo();
        $html = ob_get_clean();
        $tidy = tidy_parse_string($html);
        $this->setContent(strval($tidy->body()));
        $this->class[] = 'phpinfo';
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Phpinfo.scss';
    }
}
