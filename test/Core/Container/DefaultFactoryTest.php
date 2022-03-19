<?php

namespace ParsTest\Core\Container;

use Pars\Core\Container\DefaultFactory;

class DefaultFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldCreateByNameAndPassConstructorArgs()
    {
        $factory = new DefaultFactory(MockContainer::getInstance());
        /* @var ExampleClass $obj */
        $obj = $factory->create(['bar'], ExampleClass::class);
        $this->assertEquals('bar', $obj->getFoo());
    }
}