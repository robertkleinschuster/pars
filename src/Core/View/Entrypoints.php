<?php

namespace Pars\Core\View;

use Psr\Http\Message\ResponseInterface;

class Entrypoints
{
    protected static Entrypoints $instance;

    final private function __construct()
    {
        // private singleton
    }

    public static function getInstance(): Entrypoints
    {
        if (!isset(self::$instance)) {
            self::$instance = new Entrypoints();
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
        $result = strtolower(str_replace(['./src/', '/', '.ts'], ['', '_', ''], $entrypoint));
        return implode('_', array_unique(explode('_', $result)));
    }

    public function load()
    {
        if (empty($this->entrypointData)) {
            $this->entrypointData = json_decode(file_get_contents('public/static/entrypoints.json'), true);
        }
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
            $result .= "<link class='css' rel='stylesheet' href='$dumpFile'>";
        }
        return $result;
    }

    public static function dumpJs()
    {
        $result = '';
        foreach (self::getInstance()->dumpFiles('js') as $dumpFile) {
            $result .= "<script class='script' defer src='$dumpFile'></script>";
        }
        return $result;
    }

    public static function injectHeaders(ResponseInterface $response): ResponseInterface
    {
        $css = self::getInstance()->dumpFiles('css');
        $js = self::getInstance()->dumpFiles('js');
        if (!empty($css)) {
            foreach ($css as $key => $file) {
                if ($key > 3) {
                    break;
                }
                $response = $response->withAddedHeader('Link', "<$file>; rel=preload; as=style;");
            }
        }
        if (!empty($js)) {
            foreach ($js as $key => $file) {
                if ($key > 1) {
                    break;
                }
                $response = $response->withAddedHeader('Link', "<$file>; rel=preload; as=script;");
            }
        }
        return $response;
    }
}
