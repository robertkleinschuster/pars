<?php

namespace Pars\Core\Application\Console;

use Pars\Core\Application\Base\AbstractApplication;

class ConsoleApplication extends AbstractApplication
{
    public const COMMAND_GENERATE_CLASS = 'generate:class';

    /**
     */
    public function run(array $params = [])
    {
        $command = array_shift($params);
        if (!$command) {
            echo "Available commands:\n";
            echo " -> " . self::COMMAND_GENERATE_CLASS . ' <className>';
            echo "\n\n";
        } else {
            echo $this->createObject($command, $params)->run() . "\n\n";
        }
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

    protected function init()
    {

    }


}