<?php

namespace ParsTest\Core\Util\Option;

use Pars\Core\Util\Option\OptionHelper;
use PHPUnit\Framework\TestCase;

class OptionHelperTest extends TestCase
{
    public function testOptionsCanBeEnabledOrDisabled()
    {
        $helper = new OptionHelper();
        $helper->enable('foo');
        $helper->enable('bar');
        $helper->disable('bar');

        $this->assertContains('foo', $helper->enabled());
        $this->assertNotContains('foo', $helper->disabled());
        $this->assertContains('bar', $helper->disabled());
        $this->assertNotContains('bar', $helper->enabled());
    }
}
