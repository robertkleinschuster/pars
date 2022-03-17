<?php

namespace Pars\Core\Console;

use Pars\Core\Console\Command\BuildEntrypointsCommand;
use Pars\Core\Console\Command\DevelopmentCommand;

class ConsoleInfo
{
    public function getClassMap(): array
    {
        return [
            Console::COMMAND_BUILD_ENTRYPOINTS => BuildEntrypointsCommand::class,
            Console::COMMAND_DEVELOPMENT => DevelopmentCommand::class,
        ];
    }

    public function getCommandList(): array
    {
        return array_keys($this->getClassMap());
    }
}
