<?php
namespace ParsTest\Core\Http\Uri;

use HttpSoft\Message\Uri;
use HttpSoft\Message\UriFactory;
use Pars\Core\Http\Uri\UriBuilder;

class UriBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testAppendToUri()
    {
        $builder = new UriBuilder(new UriFactory());
        $base = new Uri('/admin');
        $append = new Uri('/login');
        $this->assertEquals('/admin/login', $builder->merged($base, $append));
    }

    public function testAppendToUriWithEmptyBase()
    {
        $builder = new UriBuilder(new UriFactory());
        $base = new Uri();
        $append = new Uri('/login');
        $this->assertEquals('/login', $builder->merged($base, $append));
    }

    public function testAppendToUriWithQueryParams()
    {
        $builder = new UriBuilder(new UriFactory());
        $base = new Uri('/admin');
        $base = $base->withQuery('foo=bar&baz=bam');
        $append = new Uri('/login');
        $append = $append->withQuery('filter=test');
        $this->assertEquals('/admin/login?foo=bar&baz=bam&filter=test', $builder->merged($base, $append)->__toString());
    }

    public function testAppendToBaseUri()
    {
        $builder = new UriBuilder(new UriFactory());
        $this->assertEquals('', $builder->__toString());
        $builder->addBaseUri(new Uri('/admin'));
        $this->assertEquals('/admin', $builder->__toString());
        $builder->addBaseUri(new Uri('/second'));
        $this->assertEquals('/admin/second', $builder->__toString());
        $this->assertEquals('/admin/second/target', $builder->withUri(new Uri('/target'))->__toString());
        $this->assertEquals('/admin/second', $builder->__toString());
    }

    public function testQueryParamsFromArray()
    {
        $builder = new UriBuilder(new UriFactory());
        $builder->addBaseUri(new Uri('/admin'));
        $this->assertEquals('/admin/index?a=b', $builder->withPath('/index')->withParams(['a' => 'b'])->__toString());
    }
}