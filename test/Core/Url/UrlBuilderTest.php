<?php
namespace ParsTest\Core\Url;

use GuzzleHttp\Psr7\Uri;
use Pars\Core\Url\UrlBuilder;

class UrlBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testAppendToUri()
    {
        $builder = new UrlBuilder();
        $base = new Uri('/admin');
        $append = new Uri('/login');
        $this->assertEquals('/admin/login', $builder->merge($base, $append));
    }


    public function testAppendToUriWithEmptyBase()
    {
        $builder = new UrlBuilder();
        $base = new Uri();
        $append = new Uri('/login');
        $this->assertEquals('/login', $builder->merge($base, $append));
    }

    public function testAppendToUriWithQueryParams()
    {
        $builder = new UrlBuilder();
        $base = new Uri('/admin');
        $base = $base->withQuery('foo=bar&baz=bam');
        $append = new Uri('/login');
        $append = $append->withQuery('filter=test');
        $this->assertEquals('/admin/login?foo=bar&baz=bam&filter=test', $builder->merge($base, $append)->__toString());
    }

    public function testAppendToBaseUri()
    {
        $builder = new UrlBuilder();
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
        $builder = new UrlBuilder();
        $builder->addBaseUri(new Uri('/admin'));
        $this->assertEquals('/admin/index?a=b', $builder->withPath('/index')->withParams(['a' => 'b'])->__toString());
    }
}