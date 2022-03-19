<?php

namespace Pars\Core\Console;

class ConsoleMessage
{
    public function noCommand(): string
    {
        return 'No command given.';
    }

    public function unknownCommand(string $command): string
    {
        return "Unknown command: $command";
    }
}
