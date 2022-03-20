<?php

namespace ParsTest\Core\Console;

use Pars\Core\Console\Console;
use Pars\Core\Console\ConsoleMessage;
use PHPUnit\Framework\TestCase;

class ConsoleTest extends TestCase
{
    public function testShouldPrintNoCommandMessage()
    {
        ob_start();
        $console = new Console();
        $console->run([]);
        $result = ob_get_clean();
        $message = new ConsoleMessage();
        $this->assertStringContainsString($message->noCommand(), $result);
    }

    public function testShouldPrintUnknownCommandMessage()
    {
        ob_start();
        $console = new Console();
        $console->run(['foo']);
        $result = ob_get_clean();
        $message = new ConsoleMessage();
        $this->assertStringContainsString($message->unknownCommand('foo'), $result);
    }

    public function testShouldExecuteCommand()
    {
        ob_start();
        $console = new Console();
        $console->setInfo(new MockConsoleInfo());
        $console->run(['mock']);
        $result = ob_get_clean();
        $this->assertStringContainsString('hello from mock command', $result);
    }

    public function testShouldPassArgumentsToCommand()
    {
        ob_start();
        $console = new Console();
        $console->setInfo(new MockConsoleInfo());
        $console->run(['mock', 'foo']);
        $result = ob_get_clean();
        $this->assertStringContainsString('has foo', $result);
        $this->assertStringNotContainsString('has bar', $result);
    }
}
