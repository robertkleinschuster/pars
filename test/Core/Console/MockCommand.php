<?php

namespace ParsTest\Core\Console;

use Pars\Core\Console\Command\AbstractCommand;

class MockCommand extends AbstractCommand
{
    public function execute()
    {
        echo 'hello from mock command';
        if ($this->getParameter()->has('foo')) {
            echo 'has foo';
        }
        if ($this->getParameter()->has('bar')) {
            echo 'has bar';
        }
    }
}