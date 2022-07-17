<?php

namespace Pars\Core\Application\Debug;

use Laminas\ConfigAggregator\ConfigAggregator;
use Mezzio\Container;
use Mezzio\Middleware\ErrorResponseGenerator;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            ConfigAggregator::ENABLE_CACHE => false,
            'debug' => true,
            'dependencies' => [
                'factories' => [
                    ErrorResponseGenerator::class => Container\WhoopsErrorResponseGeneratorFactory::class,
                    'Mezzio\Whoops'               => Container\WhoopsFactory::class,
                    'Mezzio\WhoopsPageHandler'    => Container\WhoopsPageHandlerFactory::class,
                ],
            ],
            'whoops'       => [
                'json_exceptions' => [
                    'display'    => true,
                    'show_trace' => true,
                    'ajax_only'  => true,
                ],
            ],
        ];
    }
}
