<?php

namespace Pars\Core\Application\Console\Generate;

use Pars\Core\Generator\EmptyClass\EmptyClassGenerator;

class GenerateClass
{

    protected array $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }


    public function run(): string
    {
        if (isset($this->params[0])) {
            $generator = new EmptyClassGenerator();
            $generator->generateClass($this->params[0]);
            return 'Generated: ' . $this->params[0];
        } else {
            return 'Error';
        }
    }
}