<?php

namespace ParsTest\Core\Stream;

use Pars\Core\Stream\ClosureStream;

class ClosureStreamTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldExecuteClosure()
    {
        $closureStream = new ClosureStream(
            \Closure::fromCallable(function () {
                return 'foo';
            })
        );

        $this->assertEquals('foo', $closureStream->getContents());
    }
}