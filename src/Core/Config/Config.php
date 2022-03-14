<?php
namespace Pars\Core\Config;

class Config
{
    protected array $data;

    public function __construct()
    {
        $this->load();
    }

    protected function load()
    {
        $files = glob(getcwd() . '/config/*.php');
        foreach ($files as $file) {
            $key = basename($file, '.php');
            if (!str_ends_with($key, 'development')) {
                $this->data[$key] = $this->loadFile($file);
            }
        }
        $developmentFiles = glob(getcwd() . '/config/*.development.php');
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
