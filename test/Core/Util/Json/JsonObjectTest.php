<?php

namespace ParsTest\Core\Util\Json;

use Pars\Core\Util\Json\JsonObject;
use PHPUnit\Framework\TestCase;

class JsonObjectTest extends TestCase
{
    public function testShouldInitializePropertiesFromArray()
    {
        $jsonObject = new class(['foo' => 'bar']) extends JsonObject {
            public $foo = '';
        };

        $this->assertEquals('bar', $jsonObject->foo);

        $jsonObject->foo = 'baz';

        $this->assertEquals('baz', $jsonObject['foo']);

        $this->expectError();
        $jsonObject->bar;
    }

    public function testShouldFindFlatScalarData()
    {
        $jsonObject = new JsonObject([
            'root' => [
                'first' => [
                    'second' => [
                        'third' => 'value'
                    ]
                ]
            ]
        ]);
        $this->assertIsArray($jsonObject->find('root'));
        $this->assertNull($jsonObject->find('root.first'));
        $this->assertEquals('default', $jsonObject->find('root.first.invalid', 'default'));
        $this->assertEquals('value', $jsonObject->find('root.first.second.third'));
        $this->assertEquals('value', $jsonObject->find('root[first][second][third]'));
        $this->assertEquals('value', $jsonObject->find('super[root][first][second][third]', null, 'super'));
    }
}
