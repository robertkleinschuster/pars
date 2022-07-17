<?php

namespace Pars\Core\View;

use Mezzio\Template\TemplateRendererInterface;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Http\Uri\UriBuilderFactory;
use Pars\Core\Translator\Translator;
use Pars\Core\View\Group\ViewGroupHandler;
use Pars\Core\View\Group\ViewGroupHandlerFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'aliases' => [
                    TemplateRendererInterface::class => ViewRendererMezzioBridge::class,
                ],
                'factories' => [
                    ViewComponentContainer::class => ViewComponentContainerFactory::class,
                    ViewRenderer::class => ViewRendererFactory::class,
                    ViewRendererMezzioBridge::class => ViewRendererMezzioBridgeFactory::class,
                    ViewGroupHandler::class => ViewGroupHandlerFactory::class,
                ],
                'invokables' => [
                ]
            ]
        ];
    }
}