<?php

namespace Pars\Core\View\Button;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewHelper;
use Pars\Core\View\ViewMessage;


class Button extends FormViewComponent implements EntrypointInterface
{
    private int $count = 0;

    /**
     * @param ViewHelper $helper
     * @return Button
     */
    public function setHelper(ViewHelper $helper): Button
    {
        $this->helper = $helper;
        return $this;
    }

    public function onClick(callable $listener)
    {
        $this->getHelper()->on('click', $listener);
    }

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Button.phtml');
        $this->onClick(function (ViewMessage $message) {
            if ($message->id == $this->getHelper()->getId()) {
                $message->html = 'test: ' . $this->count++;
                $this->getHelper()->dispatch($message);
            }
        });
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Button.ts';
    }

    protected function attr(): string
    {
        $result = parent::attr();
        $attributes[] = "name='$this->key'";
        $attributes[] = "value='{$this->getValue($this->key)}'";
        return $result . ' ' . implode(' ', $attributes);
    }
}
