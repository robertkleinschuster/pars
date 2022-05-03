<?php

namespace Pars\Core\View\Input;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Input extends ViewComponent implements EntrypointInterface
{
    public string $type = 'text';
    public string $key = '';
    public string $label = '';

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/input.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Input.ts';
    }

    protected function attr(): string
    {
        $result = parent::attr();
        $attributes[] = "type='{$this->type}'";
        $attributes[] = "name='{$this->key}'";
        $attributes[] = "value='{$this->getValue($this->key)}'";
        return $result . ' ' . implode(' ', $attributes);
    }

    /**
     * @param string $type
     * @return Input
     */
    public function setType(string $type): Input
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $key
     * @return Input
     */
    public function setKey(string $key): Input
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $label
     * @return Input
     */
    public function setLabel(string $label): Input
    {
        $this->label = $label;
        return $this;
    }
}
