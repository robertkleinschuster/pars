<?php

namespace ParsTest\Core\Application\Web;

use Pars\Core\Application\Web\WebApplication;
use Pars\Core\Http\Emitter\SapiEmitter;
use ParsTest\Core\Container\MockContainer;
use ParsTest\Core\Http\Emitter\MockSapiEmitter;
use PHPUnit\Framework\TestCase;

class WebApplicationTest extends TestCase
{
    public function testShouldRenderValidHtmlLayout()
    {
        $container = MockContainer::getInstance();
        $app = new WebApplication();
        $app->run();
        /* @var MockSapiEmitter $emitter */
        $emitter = $container->get(SapiEmitter::class);
        $html = $emitter->getResponse()->getBody()->getContents();
        $tidy = tidy_parse_string($html, ['drop-empty-elements'  => 'no']);
        $errors = tidy_error_count($tidy) + tidy_warning_count($tidy);
        $this->assertEquals(0, $errors, $tidy->errorBuffer ?? '');
    }
}