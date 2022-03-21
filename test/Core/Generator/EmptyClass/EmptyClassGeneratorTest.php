<?php

namespace ParsTest\Core\Generator\EmptyClass;

use Pars\Core\Generator\EmptyClass\EmptyClassGenerator;
use PHPUnit\Framework\TestCase;

class EmptyClassGeneratorTest extends TestCase
{
    public function testShouldGeneratePathByFQCN()
    {
        $generator = new EmptyClassGenerator();
        $result = $generator->generateFilePath("Foo\\Bar\\Baz\\Bam");
        $this->assertEquals("src/Foo/Bar/Baz/Bam.php", $result);
        $result = $generator->generateFilePath("Foo\\Bar\\Baz\\Bam", 'test');
        $this->assertEquals("test/Foo/Bar/Baz/Bam.php", $result);
    }

    public function testShouldBuildTestNameFromClassName()
    {
        $generator = new EmptyClassGenerator();
        $result = $generator->buildTestName("Foo\\Bar\\Baz\\Bam");
        $this->assertEquals("FooTest\\Bar\\Baz\\BamTest", $result);
    }

    public function testShouldExtractNamespaceFromClassName()
    {
        $generator = new EmptyClassGenerator();
        $result = $generator->extractNamespace("Foo\\Bar\\Baz\\Bam");
        $this->assertEquals("Foo\\Bar\\Baz", $result);
    }

    public function testShouldFillInPlaceholdersFromArrayData()
    {
        $template = '$PLACEHOLDER$ test $REPLACE$';
        $expected = 'Foo test Bar';
        $values = [
            'placeholder' => 'Foo',
            'replace' => 'Bar',
        ];

        $generator = new EmptyClassGenerator();
        $result = $generator->fillTemplatePlaceholder($template, $values);
        $this->assertEquals($expected, $result);
    }

    public function testShouldGenerateContentForClass()
    {
        $generator = new EmptyClassGenerator();
        $result = $generator->generateContent("Foo\\Bar\\Baz\\Bam", 'class.php.dist');
        $this->assertEquals(
            "<?php
namespace Foo\Bar\Baz;

class Bam
{

}",
            $result
        );

        $generator = new EmptyClassGenerator();
        $result = $generator->generateContent("FooTest\\Bar\\Baz\\BamTest", 'test.php.dist');
        $this->assertEquals(
            "<?php
namespace FooTest\Bar\Baz;

class BamTest extends \PHPUnit\Framework\TestCase
{

}",
            $result
        );
    }
}