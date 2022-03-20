<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\DefaultFactory;

class DefaultFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldCreateByNameAndPassConstructorArgs()
    {
        $factory = new DefaultFactory();
        /* @var ExampleClass $obj */
        $obj = $factory->create(ExampleClass::class, 'bar');
        $this->assertEquals('bar', $obj->getFoo());
    }
}