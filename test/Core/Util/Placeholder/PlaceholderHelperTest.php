<?php

namespace ParsTest\Core\Util\Placeholder;

use Pars\Core\Util\Placeholder\PlaceholderHelper;

class PlaceholderHelperTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldRemovePlaceholdersWhenNoValue()
    {
        $subject = "This is a {foo} test";
        $result = PlaceholderHelper::replacePlaceholder($subject, []);
        $this->assertEquals('This is a  test', $result);
    }

    public function testShouldReplacePlaceholderWithValues()
    {
        $subject = "This is a {foo} test";
        $result = PlaceholderHelper::replacePlaceholder($subject, ['foo' => 'bar']);
        $this->assertEquals('This is a bar test', $result);
    }
}
