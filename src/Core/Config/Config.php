<?php

namespace Pars\Core\Config;

class Config
{
    protected array $data = [];
    protected array $suffixList;
    protected string $directory;

    final public function __construct(
        string $directory = null,
        array $suffixList = ['development']
    ) {
        $this->suffixList = $suffixList;
        $this->directory = $directory ?? getcwd() . '/config';
        $this->load();
    }

    protected function load()
    {
        $this->loadWithSuffix();
        foreach ($this->suffixList as $suffix) {
            $this->loadWithSuffix($suffix);
        }
    }

    private function loadWithSuffix(string $suffix = null): void
    {
        $files = glob($this->buildPattern($suffix));
        foreach ($files as $file) {
            $key = basename($file, $this->buildSuffix($suffix));
            $exp = explode('.', $key);
            $foundSuffix = end($exp);
            if (!in_array($foundSuffix, $this->suffixList)) {
                $merged = array_replace_recursive(
                    $this->data[$key] ?? [],
                    $this->loadFile($file)
                );
                $this->data[$key] = $merged;
            }
        }
    }

    private function buildPattern(string $suffix = null): string
    {
        return "{$this->directory}/*{$this->buildSuffix($suffix)}";
    }

    private function buildSuffix(string $suffix = null): string
    {
        if (null === $suffix) {
            $result = '.php';
        } else {
            $result = ".$suffix.php";
        }
        return $result;
    }

    private function loadFile(string $file)
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
