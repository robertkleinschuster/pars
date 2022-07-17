<?php

namespace Pars\Core\Translator;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'invokable' => [
                    Translator::class => Translator::class
                ]
            ]
        ];
    }
}