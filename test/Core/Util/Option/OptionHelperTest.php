<?php

namespace ParsTest\Core\Util\Option;

use Pars\Core\Util\Option\OptionsObject;
use PHPUnit\Framework\TestCase;

class OptionHelperTest extends TestCase
{
    public function testOptionsCanBeEnabledOrDisabled()
    {
        $helper = new OptionsObject();
        $helper->enable('foo');
        $helper->enable('bar');
        $helper->disable('bar');

        $this->assertTrue($helper->has('foo'));
        $this->assertFalse($helper->has('bar'));
        $this->assertFalse($helper->offsetGet('bar'));
    }
}
