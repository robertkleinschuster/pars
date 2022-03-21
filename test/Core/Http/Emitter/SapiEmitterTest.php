<?php

namespace ParsTest\Core\Http\Emitter;

use HttpSoft\Message\Response;
use Pars\Core\Http\Emitter\SapiEmitter;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SapiEmitterTest extends TestCase
{
    public function testShouldThrowExceptionWhenHeadersSent()
    {
        $this->expectException(RuntimeException::class);
        $emitter = new SapiEmitter();
        $emitter->emit(new Response());
    }
}
