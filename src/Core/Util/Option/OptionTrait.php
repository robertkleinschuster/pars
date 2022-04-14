<?php

namespace Pars\Core\Util\Option;

trait OptionTrait
{
    private OptionHelper $options;

    /**
     * @return OptionHelper
     */
    public function getOptions(): OptionHelper
    {
        if (!isset($this->options)) {
            $this->options = new OptionHelper();
        }
        return $this->options;
    }
}
