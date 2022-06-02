<?php

namespace Pars\Core\View\Editor;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewComponent;
use Psr\Http\Message\StreamInterface;

class Editor extends FormViewComponent implements EntrypointInterface
{
    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Editor.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Editor.ts';
    }

    public function getContent(): StreamInterface|string
    {
        $content = parent::getContent();
        if (empty($content)) {
            $content = $this->getModel()->getValue();
        }
        return $content;
    }


}
