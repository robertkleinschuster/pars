<?php

namespace Pars\Core\View\Button;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewHelper;
use Pars\Core\View\ViewMessage;
use Pars\Core\View\ViewRenderer;


class Button extends FormViewComponent implements EntrypointInterface
{
    private ViewHelper $helper;
    private int $count = 0;

    /**
     * @return ViewHelper
     */
    public function getHelper(): ViewHelper
    {
        return $this->helper;
    }

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
        foreach ($this->getHelper()->getEvents() as $event) {
            $attributes[] = "on$event='this.dispatch(arguments[0])'";
        }
        $attributes[] = "data-id='{$this->getHelper()->getId()}'";
        return $result . ' ' . implode(' ', $attributes);
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $this->onClick(function (ViewMessage $message) use ($renderer) {
            if ($message->id == $this->getHelper()->getId()) {
                $message->html = 'test: ' . $this->count++;
                $this->getHelper()->dispatch($message);
            }
        });
    }
}
