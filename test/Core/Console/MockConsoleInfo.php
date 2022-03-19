<?php

namespace ParsTest\Core\Console;

use Pars\Core\Console\ConsoleInfo;

class MockConsoleInfo extends ConsoleInfo
{
    public function getClassMap(): array
    {
        return [
            'mock' => MockCommand::class
        ];
    }
}