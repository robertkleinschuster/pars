<?php

namespace Pars\Core\Console;

use Pars\Core\Console\Command\ConsoleCommandException;

class Console
{
    public const COMMAND_BUILD_ENTRYPOINTS = 'build-entrypoints';
    public const COMMAND_DEVELOPMENT = 'development';

    private ConsoleCommandFactory $factory;
    private ConsoleInfo $info;
    private ConsoleColors $colors;

    /**
     * @return ConsoleCommandFactory
     */
    public function getFactory(): ConsoleCommandFactory
    {
        if (!isset($this->factory)) {
            $this->factory = new ConsoleCommandFactory($this->getInfo());
        }
        return $this->factory;
    }

    /**
     * @param ConsoleCommandFactory $factory
     * @return Console
     */
    public function setFactory(ConsoleCommandFactory $factory): Console
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return ConsoleInfo
     */
    public function getInfo(): ConsoleInfo
    {
        if (!isset($this->info)) {
            $this->info = create(ConsoleInfo::class);
        }
        return $this->info;
    }

    /**
     * @param ConsoleInfo $info
     * @return Console
     */
    public function setInfo(ConsoleInfo $info): Console
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return ConsoleColors
     */
    public function getColors(): ConsoleColors
    {
        if (!isset($this->colors)) {
            $this->colors = create(ConsoleColors::class);
        }
        return $this->colors;
    }


    public function run(array $params = [])
    {
        try {
            $command = $this->getFactory()->create(array_shift($params));
            $command->setParameter(new ConsoleParameter($params));
            $command->execute();
        } catch (ConsoleCommandException $exception) {
            echo $this->getColors()->format("Command error:\n", 'light_red', 'red');
            echo $this->getColors()->format($exception->getMessage(), 'red');
            echo "\n";
        } catch (ConsoleException $exception) {
            echo $this->getColors()->format($exception->getMessage(), 'red');
            echo "\n";
            $this->echoHelp();
        }
    }

    private function echoHelp()
    {
        echo $this->getColors()->format("Console: ", 'light_green', 'green');
        echo "\n";
        foreach ($this->getInfo()->getCommandList() as $commandCode) {
            echo $this->getColors()->format("    $commandCode\n", 'cyan');
        }
        echo "\n";
    }
}
