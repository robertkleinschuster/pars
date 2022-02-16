<?php

namespace Pars\Core\Application\Console\Generate;

use Pars\Core\Application\Console\ConsoleInterface;
use Pars\Core\Generator\EmptyClass\EmptyClassGenerator;

class GenerateClass implements ConsoleInterface
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
        $result = 'missing: ' . self::description();
        if (isset($this->params[0])) {
            $generator = new EmptyClassGenerator();
            $generator->generateClass($this->params[0]);
            $result = 'Generated: ' . $this->params[0];
        }
        return $result;
    }

    public static function description(): string
    {
        return '<className>';
    }

    public static function command(): string
    {
        return 'generate:class';
    }
}