<?php

namespace Pars\Core\Util\Option;

trait OptionTrait
{
    private OptionsObject $options;

    /**
     * @return OptionsObject
     */
    public function getOptions(): OptionsObject
    {
        if (!isset($this->options)) {
            $this->options = new OptionsObject();
        }
        return $this->options;
    }
}
