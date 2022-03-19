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
}
