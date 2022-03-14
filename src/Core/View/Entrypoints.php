<?php

namespace Pars\Core\View;

use Psr\Http\Message\ResponseInterface;

class Entrypoints
{
    protected static self $instance;

    private function __construct()
    {
        // private singleton
    }

    public static function getInstance(): static
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    protected array $entrypointData = [];
    protected array $entrypointsEnabled = [];

    public static function add(string $entrypoint)
    {
        self::getInstance()->entrypointsEnabled[] = self::buildEntrypointName(self::buildEntrypoint($entrypoint));
    }

    public static function buildEntrypoint(string $entrypoint)
    {
        return '.' . str_replace(getcwd(), '', $entrypoint);
    }

    public static function buildEntrypointName(string $entrypoint)
    {
        return strtolower(str_replace(['./src/', '/', '.ts'], ['', '_', ''], $entrypoint));
    }

    public function load()
    {
        if (empty($this->entrypointData)) {
            $this->entrypointData = json_decode(file_get_contents('public/static/entrypoints.json'), true);
        }
    }

    public function save()
    {
        if (!file_exists('data/cache')) {
            mkdir('data/cache', 0777, true);
        }
        file_put_contents('data/cache/entrypoints.php', '<?php return ' . var_export($this->entrypointData, true) . ';');
    }

    protected function dumpFiles(string $key)
    {
        $this->load();
        $result = [];
        foreach ($this->entrypointsEnabled as $viewEntrypoint) {
            if (isset($this->entrypointData['entrypoints'][$viewEntrypoint][$key])) {
                $files = $this->entrypointData['entrypoints'][$viewEntrypoint][$key];
                foreach ($files as $file) {
                    $result[$file] = $file;
                }
            }
        }
        return array_values($result);
    }


    public static function dumpCss()
    {
        $result = '';
        foreach (self::getInstance()->dumpFiles('css') as $dumpFile) {
            $result .= "<link rel='stylesheet' href='$dumpFile'>";
        }
        return $result;
    }

    public static function dumpJs()
    {
        $result = '';
        foreach (self::getInstance()->dumpFiles('js') as $dumpFile) {
            $result .= "<script defer src='$dumpFile'></script>";
        }
        return $result;
    }

    public static function injectHeaders(ResponseInterface $response): ResponseInterface
    {
        $css = self::getInstance()->dumpFiles('css');
        $js = self::getInstance()->dumpFiles('js');
        if (!empty($css)) {
            $response = $response->withAddedHeader('inject-css', self::getInstance()->dumpFiles('css'));
        }
        if (!empty($js)) {
            $response = $response->withAddedHeader('inject-js', self::getInstance()->dumpFiles('js'));
        }
        return $response;
    }

}