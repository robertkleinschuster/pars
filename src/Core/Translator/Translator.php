<?php
namespace Pars\Core\Translator;

use Locale;
use Pars\Core\Placeholder\PlaceholderHelper;

class Translator
{
    protected static array $files = [];
    protected static array $paths = [];
    public function __construct()
    {
        $this->addPath(__DIR__ . '/translations');
    }

    public function translate(string $code, array $placeholder = []): string
    {
        $translations = $this->loadTranslations();
        return PlaceholderHelper::replacePlaceholder($translations[$code] ?? $code, $placeholder);
    }

    public function translatepl(string $code, int $count, array $placeholder = []): string
    {
        $translations = $this->loadTranslations();
        for ($i = $count; $i >= 0; $i--) {
            if (isset($translations["$code.$i"])) {
                return PlaceholderHelper::replacePlaceholder($translations["$code.$i"] ?? $code, $placeholder);
            }
        }
        return PlaceholderHelper::replacePlaceholder($translations[$code] ?? $code, $placeholder);
    }

    protected function loadTranslations(): array
    {
        if (empty(static::$files)) {
            foreach (static::$paths as $path) {
                $locale = Locale::getDefault();
                $language = Locale::getPrimaryLanguage($locale);
                $this->addFile($path . DIRECTORY_SEPARATOR . $language . '.php');
                $this->addFile($path . DIRECTORY_SEPARATOR . $locale . '.php');
            }
        }
        $translations = [];
        foreach (static::$files as $file) {
            $data = include $file;
            if (is_array($data)) {
                $translations = array_replace($translations, $data);
            }
        }
        return $translations;
    }

    public function addPath(string $path): static
    {
        static::$paths[$path] = $path;
        return $this;
    }

    public function addFile(string $file): static
    {
        if (!isset(static::$files[$file]) && file_exists($file)) {
            static::$files[$file] = $file;
        }
        return $this;
    }
}