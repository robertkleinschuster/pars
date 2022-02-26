<?php

namespace Pars\Core\Application\Console;

use Pars\Core\Application\Base\AbstractApplication;

class ConsoleApplication extends AbstractApplication
{

    /**
     */
    public function run(array $params = [])
    {
        $command = array_shift($params);
        if (!$command) {
            echo "\nCommands:";
            foreach ($this->descriptionMap() as $command => $description) {
                echo "\n - $command $description";
            }
            echo "\n\n";
        } else {
            echo $this->createObject($command, $params)->run() . "\n\n";
        }
    }

    /**
     */
    protected function createObject(string $command, array $params): ConsoleInterface
    {
        $class = $this->classMap()[$command];
        return $this->container->get($class, $params);
    }


    protected function classMap(): array
    {
        return [
            Generate\GenerateClass::command() => Generate\GenerateClass::class,
            Development\Development::command() => Development\Development::class,
            Build\BuildEntrypoints::command() => Build\BuildEntrypoints::class,
        ];
    }

    protected function descriptionMap(): array
    {
        return [
            Generate\GenerateClass::command() => Generate\GenerateClass::description(),
            Development\Development::command() => Development\Development::description(),
            Build\BuildEntrypoints::command() => Build\BuildEntrypoints::description(),
        ];
    }



    protected function init()
    {

    }


}