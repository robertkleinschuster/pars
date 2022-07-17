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
     * @return AbstractCommand
     * @throws ConsoleException
     */
    public function create(?string $command): AbstractCommand
    {
        $message = new ConsoleMessage();
        if (null === $command) {
            throw new ConsoleException($message->noCommand());
        }
        $map = $this->info->getClassMap();
        if (!isset($map[$command])) {
            throw new ConsoleException($message->unknownCommand($command));
        }
        return new $map[$command]();
    }
}
