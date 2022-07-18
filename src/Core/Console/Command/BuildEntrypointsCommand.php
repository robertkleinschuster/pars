<?php

namespace Pars\Core\Console\Command;

use Pars\Core\Util\TokenScanner;
use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Entrypoints;

class BuildEntrypointsCommand extends AbstractCommand
{
    public function execute()
    {
        $classes = $this->findClasses();

        $entrypoints = [];
        foreach ($classes as $class) {
            if (class_exists($class) && is_subclass_of($class, EntrypointInterface::class)) {
                $entrypoint = $class::getEntrypoint();
                $entrypoint = Entrypoints::buildEntrypoint($entrypoint);
                $entrypoints[Entrypoints::buildEntrypointName($entrypoint)] = $entrypoint;
            }
        }
        $json = json_encode($entrypoints);
        $filename = 'entrypoints.json';
        file_put_contents($filename, $json);

        $count = $this->getColors()->format((string) count($entrypoints), 'green');
        echo "Written $count entrypoints to $filename.";
    }


    private function findClasses(): array
    {
        $classes = [];
        $iti = new \RecursiveDirectoryIterator(getcwd() . '/src');
        $scanner = new TokenScanner();
        foreach (new \RecursiveIteratorIterator($iti) as $file) {
            $file = (string)$file;
            if (str_ends_with($file, '.php')) {
                $class = $scanner->getClassNameFromFile($file);
                if ($class) {
                    $classes[] = $class;
                }
            }
        }
        return $classes;
    }
}
