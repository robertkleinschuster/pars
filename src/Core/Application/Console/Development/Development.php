<?php

namespace Pars\Core\Application\Console\Development;

use Pars\Core\Application\Console\ConsoleInterface;

class Development implements ConsoleInterface
{
    protected const MODE_ENABLE = 'enable';
    protected const MODE_DISABLE = 'disable';
    protected array $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function run(): string
    {
        $result = 'missing: ' . self::description();

        switch (reset($this->params)) {
            case self::MODE_ENABLE:
                $this->enable();
                $result = 'enabled';
                break;
            case self::MODE_DISABLE:
                $this->disable();
                $result = 'disabled';
                break;
        }

        return $result;
    }

    protected function enable()
    {
        foreach (glob(getcwd() . '/config/*.development.*') as $item) {
            $exp = explode('.', $item);
            if (end($exp) == 'dist') {
                array_pop($exp);
                copy($item, implode('.', $exp));
            }
        }
    }

    protected function disable()
    {
        foreach (glob(getcwd() . '/config/*.development.*') as $item) {
            $exp = explode('.', $item);
            if (end($exp) == 'php') {
                unlink(implode('.', $exp));
            }
        }
    }

    public static function description(): string
    {
        return '<enable|disable>';
    }

    public static function command(): string
    {
        return 'development';
    }


}
