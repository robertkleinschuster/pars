<?php

namespace Pars\Core\Console\Command;

class DevelopmentCommand extends AbstractCommand
{
    public function execute()
    {
        if ($this->getParameter()->has('enable')) {
            $this->enable();
        } elseif ($this->getParameter()->has('disable')) {
            $this->enable();
        } else {
            throw new ConsoleCommandException('Missing option: enable|disable');
        }
    }


    protected function enable()
    {
        foreach (glob(getcwd() . '/config/*.development.*') as $item) {
            $exp = explode('.', $item);
            if (end($exp) == 'dist') {
                array_pop($exp);
                copy($item, implode('.', $exp));
            }
        }
    }

    protected function disable()
    {
        foreach (glob(getcwd() . '/config/*.development.*') as $item) {
            $exp = explode('.', $item);
            if (end($exp) == 'php') {
                unlink(implode('.', $exp));
            }
        }
    }
}
