<?php

namespace Pars\Core\View;

use Mezzio\Template\TemplateRendererInterface;

class ViewRendererMezzioBridge implements TemplateRendererInterface
{
    private ViewComponentContainer $container;
    private ViewRenderer $renderer;
    private array $defaultParams = [];

    /**
     * @param ViewComponentContainer $container
     * @param ViewRenderer $renderer
     */
    public function __construct(ViewComponentContainer $container, ViewRenderer $renderer)
    {
        $this->container = $container;
        $this->renderer = $renderer;
    }

    public function render(string $name, $params = []): string
    {
        $componenent = $this->container->get($name);
        $params = array_replace_recursive($this->getDefaultParams($name), $params);
        foreach ($params as $key => $value) {
            $componenent->getModel()->set($key, $value);
        }
        $this->renderer->setComponent($componenent);
        return (string)$this->renderer->render();
    }

    private function getDefaultParams(string $name): array
    {
        $componentParams = $this->defaultParams[$name] ?? [];
        $globalParams = $this->defaultParams[self::TEMPLATE_ALL] ?? [];
        return array_replace_recursive($globalParams, $componentParams);
    }

    public function addPath(string $path, ?string $namespace = null): void
    {
        $this->throwUnsupportedException();
    }

    public function getPaths(): array
    {
        $this->throwUnsupportedException();
    }

    private function throwUnsupportedException()
    {
        throw new ViewException('Paths currently not suppoerted for components.');
    }

    public function addDefaultParam(string $templateName, string $param, $value): void
    {
        $this->defaultParams[$templateName][$param] = $value;
    }
}
