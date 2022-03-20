<?php

namespace ParsTest\Core\Translator;

use Locale;
use Pars\Core\Translator\Translator;

class TranslatorTest extends \PHPUnit\Framework\TestCase
{
    public function testTranslationsDe()
    {
        $defaultLocale = Locale::getDefault();
        Locale::setDefault('en_US');
        $translator = new Translator();
        $translator->addPath(__DIR__ . '/examples');
        $this->assertEquals('en', $translator->translate('foo'));
        Locale::setDefault($defaultLocale);
    }

    public function testTranslationEn()
    {
        $defaultLocale = Locale::getDefault();
        Locale::setDefault('de_AT');
        $translator = new Translator();
        $translator->addPath(__DIR__ . '/examples');
        $this->assertEquals('de', $translator->translate('foo'));
        Locale::setDefault($defaultLocale);
    }
}
