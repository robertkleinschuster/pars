<?php

namespace ParsTest\Core\Container;

class ExampleClass
{
    protected string $foo;

    /**
     * @param string $foo
     */
    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getFoo(): string
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     * @return ExampleClass
     */
    public function setFoo(string $foo): ExampleClass
    {
        $this->foo = $foo;
        return $this;
    }



}