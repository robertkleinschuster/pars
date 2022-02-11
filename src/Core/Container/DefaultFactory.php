<?php

namespace Pars\Core\Container;

use JetBrains\PhpStorm\Pure;
use Throwable;

class DefaultFactory implements ContainerFactoryInterface
{
    public const GENERATE_PATH = 'generated' . DIRECTORY_SEPARATOR . 'factories';
    protected string $className;

    public function __construct()
    {
        if (!is_dir(self::GENERATE_PATH)) {
            mkdir(self::GENERATE_PATH, 0777, true);
        }
    }

    /**
     * @throws Throwable
     */
    #[Pure] public function create(array $params, string $id): mixed
    {
        $class = $id;
        try {
            return ($this->generateFactory($class))(...$params);
        } catch (Throwable $exception) {
            $fileName = str_replace("\\", '-', $class);
            $fileName = self::GENERATE_PATH . DIRECTORY_SEPARATOR . $fileName . '.php';
            unlink($fileName);
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($fileName);
            }
            throw $exception;
        }
    }

    protected function generateFactory(string $className)
    {
        $fileName = str_replace("\\", '-', $className);
        $fileName = self::GENERATE_PATH . DIRECTORY_SEPARATOR . $fileName . '.php';
        $factory = @include $fileName;
        if (!$factory) {
            $this->writeGenerated($className, $fileName);
            $factory = include $fileName;
        }
        return $factory;
    }

    protected function writeGenerated(string $className, string $fileName)
    {
        $content = "<?php return function(...\$params) {
    return new $className(...\$params);
};";
        file_put_contents($fileName, $content);
    }
}