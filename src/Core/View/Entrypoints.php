<?php

namespace Pars\Core\View;

class Entrypoints
{
    protected array $entrypointData = [];
    protected array $entrypointsEnabled = [];

    public function __construct()
    {
        $this->enable(ViewHelper::getEntrypoint());
    }


    public function enable(string $entrypoint)
    {
        $this->entrypointsEnabled[] = self::buildEntrypointName(self::buildEntrypoint($entrypoint));
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

    public function dumpFiles(string $key)
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


    public function dumpCss()
    {
        $result = '';
        foreach ($this->dumpFiles('css') as $dumpFile) {
            $result .= "<link class='css' rel='stylesheet' href='$dumpFile'>";
        }
        return $result;
    }

    public function dumpJs()
    {
        $result = '';
        foreach ($this->dumpFiles('js') as $dumpFile) {
            $result .= "<script class='script' defer src='$dumpFile'></script>";
        }
        return $result;
    }
}
