<?php

namespace Pars\Core\View;

use Psr\Http\Message\ResponseInterface;

class Entrypoints
{
    protected static $entrypoints = [];

    public static function buildEntrypoint(string $entrypoint)
    {
        return '.' . str_replace(getcwd(), '', $entrypoint);
    }

    public static function buildEntrypointName(string $entrypoint)
    {
        return strtolower(str_replace(['./src/', '/', '.ts'], ['', '_', ''], $entrypoint));
    }

    public static function load()
    {
        if (empty(self::$entrypoints)) {
            self::$entrypoints = json_decode(file_get_contents('public/static/entrypoints.json'), true);
        }
    }

    public static function dumpCss()
    {
        $result = '';
        foreach (self::dumpFiles('css') as $dumpFile) {
            $result .= "<link rel='stylesheet' href='$dumpFile'>";
        }
        return $result;
    }

    protected static function dumpFiles(string $key)
    {
        self::load();
        $result = [];
        $viewEntrypoints = ViewRenderer::$entrypoints;
        foreach ($viewEntrypoints as $viewEntrypoint) {
            if (isset(self::$entrypoints['entrypoints'][$viewEntrypoint][$key])) {
                $files = self::$entrypoints['entrypoints'][$viewEntrypoint][$key];
                foreach ($files as $file) {
                    $result[$file] = $file;
                }
            }
        }
        return array_values($result);
    }

    public static function dumpJs()
    {
        self::load();
        $result = '';
        foreach (self::dumpFiles('js') as $dumpFile) {
            $result .= "<script defer src='$dumpFile'></script>";
        }
        return $result;
    }

    public static function injectHeaders(ResponseInterface $response): ResponseInterface
    {
        $css = self::dumpFiles('css');
        $js = self::dumpFiles('js');
        if (!empty($css)) {
            $response = $response->withAddedHeader('inject-css', self::dumpFiles('css'));
        }
        if (!empty($js)) {
            $response = $response->withAddedHeader('inject-js', self::dumpFiles('js'));
        }
        return $response;
    }

}