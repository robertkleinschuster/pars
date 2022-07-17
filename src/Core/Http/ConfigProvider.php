<?php

namespace Pars\Core\Http;

use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Http\Uri\UriBuilderFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'factories' => [
                    UriBuilder::class => UriBuilderFactory::class
                ]
            ]
        ];
    }
}
