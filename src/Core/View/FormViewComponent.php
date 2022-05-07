<?php

namespace Pars\Core\View;

use Pars\Core\View\Input\Input;

class FormViewComponent extends ViewComponent
{
    public string $key = '';
    public string $label = '';

    /**
     * @param string $key
     * @return Input
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $label
     * @return Input
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }
}