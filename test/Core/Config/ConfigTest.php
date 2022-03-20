<?php

namespace ParsTest\Core\Config;

use Pars\Core\Config\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldLoadFilesFromDirectoryAndUseFilenamesAsKeys()
    {
        $config = new Config(__DIR__ . '/examples/production');
        $this->assertEquals('production', $config->get('foo.bar'));
    }

    public function testShouldOverrideWithDevelopmentFiles()
    {
        $config = new Config(__DIR__ . '/examples/development');
        $this->assertEquals('development', $config->get('foo.bar'));
    }

    public function testShouldResolveKeyRecursivly()
    {
        $config = new Config(__DIR__ . '/examples/production');
        $this->assertEquals('value', $config->get('level-a.level-b.level-c.level-d'));
        $this->assertEquals(['level-d' => 'value'], $config->get('level-a.level-b.level-c'));
    }

    public function testShouldOverrideSuffixesInOrder()
    {
        $config = new Config(__DIR__ . '/examples/suffix', ['development', 'release']);
        $this->assertEquals('release', $config->get('test.bar'));

        $config = new Config(__DIR__ . '/examples/suffix', ['development']);
        $this->assertEquals('development', $config->get('test.bar'));

        $config = new Config(__DIR__ . '/examples/suffix', []);
        $this->assertEquals('production', $config->get('test.bar'));
    }
}
