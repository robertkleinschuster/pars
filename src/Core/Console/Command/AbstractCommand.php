<?php

namespace Pars\Core\Console\Command;

use Pars\Core\Console\ConsoleColors;
use Pars\Core\Console\ConsoleException;
use Pars\Core\Console\ConsoleParameter;

abstract class AbstractCommand
{
    private ConsoleColors $colors;
    private ConsoleParameter $parameter;

    /**
     * @return ConsoleColors
     */
    public function getColors(): ConsoleColors
    {
        if (!isset($this->colors)) {
            $this->colors = new ConsoleColors();
        }
        return $this->colors;
    }

    /**
     * @return ConsoleParameter
     * @throws ConsoleException
     */
    public function getParameter(): ConsoleParameter
    {
        if (!isset($this->parameter)) {
            throw new ConsoleException('Parameter not initialized');
        }
        return $this->parameter;
    }

    /**
     * @param ConsoleParameter $parameter
     * @return AbstractCommand
     */
    public function setParameter(ConsoleParameter $parameter): AbstractCommand
    {
        $this->parameter = $parameter;
        return $this;
    }


    abstract public function execute();
}
