<?php

namespace Pars\Core\Console\Command;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Entrypoints;

class BuildEntrypointsCommand extends AbstractCommand
{
    public function execute()
    {
        ini_set('error_reporting', '0');
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

        file_put_contents('entrypoints.json', $json);
    }


    private function findClasses(): array
    {
        $classes = [];
        $iti = new \RecursiveDirectoryIterator(getcwd() . '/src');
        foreach (new \RecursiveIteratorIterator($iti) as $file) {
            if (str_ends_with($file, '.php')) {
                $file = (string)$file;
                $contents = file_get_contents($file);
                $tokens = token_get_all($contents);
                $implements = false;
                $class = false;
                $namespace = false;
                foreach ($tokens as $token) {
                    if ($token[0] == T_CLASS && $class === false) {
                        $class = true;
                    }
                    if ($token[0] == T_NAMESPACE && $namespace === false) {
                        $namespace = true;
                    }
                    if ($token[0] == T_IMPLEMENTS) {
                        $implements = true;
                    }
                    if ($token == '{') {
                        break;
                    }
                    if ($class === true && $token[0] == T_STRING) {
                        $class = $token[1];
                    }
                    if ($namespace === true && $token[0] == T_NAME_QUALIFIED) {
                        $namespace = $token[1];
                    }
                    if ($implements && $token[0] == T_STRING) {
                        if (str_contains($token[1], 'EntrypointInterface')) {
                            if (!str_starts_with($token[0], '\\')) {
                                $class = '\\' . $namespace . '\\' . $class;
                            }
                            $classes[] = $class;
                        }
                    }
                }
            }
        }
        return $classes;
    }
}
