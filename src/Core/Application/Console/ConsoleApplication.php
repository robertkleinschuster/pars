<?php

namespace Pars\Core\Application\Console;

use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Container\NotFoundException;

class ConsoleApplication extends AbstractApplication
{
    public const COMMAND_GENERATE_CLASS = 'generate:class';

    /**
     */
    public function run(array $params = [])
    {
        $command = array_shift($params);
        echo $this->createObject($command, $params)->run() . "\n";
    }

    /**
     */
    protected function createObject(string $command, array $params): Generate\GenerateClass
    {
        $class = $this->classMap()[$command];
        return $this->container->get($class, $params);
    }

    protected function classMap(): array
    {
        return [
            self::COMMAND_GENERATE_CLASS => Generate\GenerateClass::class
        ];
    }


}