<?php

namespace Pars\Core\Application\Console;

interface ConsoleInterface
{
    public function __construct(array $params);
    public function run(): string;
    public static function description(): string;
    public static function command(): string;

}