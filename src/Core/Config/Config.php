<?php

namespace Pars\Core\Config;

class Config
{
    protected array $data;
    protected string $directory;

    final public function __construct(string $directory = null)
    {
        $this->directory = $directory ?? getcwd() . '/config';
        $this->load();
    }

    protected function load()
    {
        $files = glob($this->directory . '/*.php');
        foreach ($files as $file) {
            $key = basename($file, '.php');
            if (!str_ends_with($key, 'development')) {
                $this->data[$key] = $this->loadFile($file);
            }
        }
        $developmentFiles = glob($this->directory . '/*.development.php');
        foreach ($developmentFiles as $file) {
            $key = basename($file, '.development.php');
            $this->data[$key] = array_replace_recursive($this->data[$key], $this->loadFile($file));
        }
    }

    protected function loadFile(string $file)
    {
        return require $file;
    }

    public function get(string $key, $default = null)
    {
        return $this->getRecursiveValue($this->data, $key) ?? $default;
    }

    private function getRecursiveValue($data, $keyPath)
    {
        if (!is_array($keyPath)) {
            $keyPath = explode('.', $keyPath);
        }
        if (count($keyPath) == 0) {
            return $data;
        }
        $key = array_shift($keyPath);

        return $this->getRecursiveValue($data[$key] ?? null, $keyPath);
    }
}
