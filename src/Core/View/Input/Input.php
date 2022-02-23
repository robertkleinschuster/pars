<?php
namespace Pars\Core\View\Input;

use Pars\Core\View\ViewComponent;

class Input extends ViewComponent
{

    public string $type = 'text';
    public string $key = '';
    public string $label = '';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/input.phtml');
    }

    protected function attr(): string
    {
        $result = parent::attr();
        $attributes[] = "type='{$this->type}'";
        $attributes[] = "name='{$this->key}'";
        $attributes[] = "value='{$this->getValue($this->key)}'";
        return $result . ' ' . implode(' ', $attributes);
    }


}