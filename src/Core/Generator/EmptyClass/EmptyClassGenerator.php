<?php

namespace Pars\Core\Generator\EmptyClass;

use Pars\Core\Generator\Base\AbstractGenerator;

class EmptyClassGenerator extends AbstractGenerator
{
    public const NAMESPACE_SEPARATOR = '\\';
    public const BASE_PATH_SOURCE = 'src';
    public const BASE_PATH_TEST = 'test';
    public const TEST_SUFFIX = 'Test';
    public const PLACEHOLDER_NAMESPACE = 'namespace';
    public const PLACEHOLDER_CLASSNAME = 'name';

    public function generateClass(string $className)
    {
        $content = $this->generateContent($className, 'class.php.dist');
        $this->writeFile($this->generateFilePath($className), $content);
        $testName = $this->buildTestName($className);
        $content = $this->generateContent($testName, 'test.php.dist');
        $this->writeFile($this->generateFilePathTest($testName), $content);
    }

    public function generateContent(string $className, string $template): string
    {
        $placeholder = [
            self::PLACEHOLDER_CLASSNAME => $this->extractClassName($className),
            self::PLACEHOLDER_NAMESPACE => $this->extractNamespace($className),
        ];
        $template = $this->loadTemplate($template);
        return $this->fillTemplatePlaceholder($template, $placeholder);
    }

    public function extractClassName(string $className): string
    {
        $exp = explode(self::NAMESPACE_SEPARATOR, $className);
        return array_pop($exp);
    }

    public function extractNamespace(string $className): string
    {
        $exp = explode(self::NAMESPACE_SEPARATOR, $className);
        array_pop($exp);
        return implode(self::NAMESPACE_SEPARATOR, $exp);
    }

    public function loadTemplate(string $templateName): string
    {
        return file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $templateName);
    }

    public function fillTemplatePlaceholder(string $template, array $values): string
    {
        $search = [];
        $replace = [];
        foreach ($values as $key => $value) {
            $search[] = '$' . strtoupper($key) . '$';
            $replace[] = $value;
        }
        return str_replace($search, $replace, $template);
    }

    public function writeFile(string $file, string $content)
    {
        if (!is_dir(pathinfo($file)['dirname'])) {
            mkdir(pathinfo($file)['dirname'], 0777, true);
        }
        file_put_contents($file, $content);
    }

    public function generateFilePath(string $className, string $basePath = self::BASE_PATH_SOURCE): string
    {
        $className = str_replace("Pars\\", "", $className);
        $className = str_replace("ParsTest\\", "", $className);
        return $basePath
            . DIRECTORY_SEPARATOR
            . str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $className)
            . '.php';
    }

    public function buildTestName(string $className): string
    {
        $exp = explode(self::NAMESPACE_SEPARATOR, $className);
        $exp[0] .= self::TEST_SUFFIX;
        $exp[count($exp) - 1] .= self::TEST_SUFFIX;
        return implode(self::NAMESPACE_SEPARATOR, $exp);
    }

    public function generateFilePathTest(string $className): string
    {
        return $this->generateFilePath($className, self::BASE_PATH_TEST);
    }
}
