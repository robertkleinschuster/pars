<?php

namespace Pars\Core\Console;

class ConsoleColors
{
    private array $foreground = [];
    private array $background = [];

    public function __construct()
    {
        // Set up shell colors
        $this->foreground['black'] = '0;30';
        $this->foreground['dark_gray'] = '1;30';
        $this->foreground['blue'] = '0;34';
        $this->foreground['light_blue'] = '1;34';
        $this->foreground['green'] = '0;32';
        $this->foreground['light_green'] = '1;32';
        $this->foreground['cyan'] = '0;36';
        $this->foreground['light_cyan'] = '1;36';
        $this->foreground['red'] = '0;31';
        $this->foreground['light_red'] = '1;31';
        $this->foreground['purple'] = '0;35';
        $this->foreground['light_purple'] = '1;35';
        $this->foreground['brown'] = '0;33';
        $this->foreground['yellow'] = '1;33';
        $this->foreground['light_gray'] = '0;37';
        $this->foreground['white'] = '1;37';

        $this->background['black'] = '40';
        $this->background['red'] = '41';
        $this->background['green'] = '42';
        $this->background['yellow'] = '43';
        $this->background['blue'] = '44';
        $this->background['magenta'] = '45';
        $this->background['cyan'] = '46';
        $this->background['light_gray'] = '47';
    }

    // Returns colored string
    public function format(
        string $string,
        string $foreground = null,
        string $background = null
    ): string {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground[$foreground])) {
            $colored_string .= "\033[" . $this->foreground[$foreground] . "m";
        }
        // Check if given background color found
        if (isset($this->background[$background])) {
            $colored_string .= "\033[" . $this->background[$background] . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForeground(): array
    {
        return array_keys($this->foreground);
    }

    // Returns all background color names
    public function getBackground(): array
    {
        return array_keys($this->background);
    }
}
