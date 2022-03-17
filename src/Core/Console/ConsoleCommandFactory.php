<?php

namespace Pars\Core\Console;

use Pars\Core\Console\Command\AbstractCommand;

class ConsoleCommandFactory
{
    protected ConsoleInfo $info;

    /**
     * @param ConsoleInfo $info
     */
    public function __construct(ConsoleInfo $info)
    {
        $this->info = $info;
    }


    /**
     * @param string|null $command
     * @return mixed
     * @throws ConsoleException
     */
    public function create(?string $command): AbstractCommand
    {
        if (null === $command) {
            throw new ConsoleException('No command given.');
        }
        $map = $this->info->getClassMap();
        if (!isset($map[$command])) {
            throw new ConsoleException("Unknown command: $command");
        }
        return create($map[$command]);
    }
}
