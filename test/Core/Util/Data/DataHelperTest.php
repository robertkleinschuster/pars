<?php

namespace ParsTest\Core\Util\Data;

use Pars\Core\Util\Json\JsonObject;
use PHPUnit\Framework\TestCase;

class DataHelperTest extends TestCase
{

    public function testShouldMergeData()
    {
        $helper = new JsonObject([
            'string' => 'asdf',
            'array' => [
                'foo' => 'foo',
                'bar' => 'bar'
            ]
        ]);

        $helper->from(['array' => ['foo' => 'foo2', 'baz' => ['baz' => 1]]]);

        $this->assertEquals('foo2', $helper->find('array[foo]'));
        $this->assertEquals(1, $helper->find('array[baz][baz]'));
        $this->assertEquals(1, $helper->find('array.baz.baz'));
    }

    public function testCount()
    {
        $helper = new JsonObject([
            'string' => 'asdf',
            'array' => [
                'foo' => 'foo',
                'bar' => 'bar'
            ]
        ]);
        $this->assertCount(2, $helper);
        $helper->clear();
        $this->assertCount(0, $helper);
    }
}
