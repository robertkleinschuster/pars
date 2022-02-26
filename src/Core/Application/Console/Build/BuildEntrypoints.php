<?php
namespace Pars\Core\Application\Console\Build;

use Composer\Autoload\ClassLoader;
use Pars\Core\Application\Console\ConsoleInterface;
use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Entrypoints;
use Pars\Core\View\ViewComponent;

class BuildEntrypoints implements ConsoleInterface
{

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
        ini_set('error_reporting', 0);
        $result = '';
        $iti = new \RecursiveDirectoryIterator(getcwd() . '/src');
        foreach(new \RecursiveIteratorIterator($iti) as $file){
            if (str_ends_with($file, '.php')) {
                try {
                    require_once $file;
                } catch (\Throwable $throwable) {
                    echo "\nignored $file";
                }
            }
        }
        $entrypoints = [];

        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, EntrypointInterface::class)) {
                $entrypoint = $class::getEntrypoint();
                $entrypoint =  Entrypoints::buildEntrypoint($entrypoint);
                $entrypoints[Entrypoints::buildEntrypointName($entrypoint)] = $entrypoint;
            }
        }
        $json = json_encode($entrypoints);
        file_put_contents('entrypoints.json', $json);
        return $result;
    }

    public static function description(): string
    {
        return '';
    }

    public static function command(): string
    {
        return 'build:entrypoints';
    }

}