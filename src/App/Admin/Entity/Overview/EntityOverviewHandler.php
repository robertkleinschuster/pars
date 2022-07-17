<?php

namespace Pars\App\Admin\Entity\Overview;

use Laminas\Diactoros\Response\HtmlResponse;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\Toolbar\Toolbar;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityOverviewHandler implements RequestHandlerInterface
{
    private UriBuilder $uriBuilder;
    private ViewRenderer $renderer;

    /**
     * @param ViewRenderer $renderer
     * @param UriBuilder $uriBuilder
     */
    public function __construct(ViewRenderer $renderer, UriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
        $this->renderer = $renderer;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parent = $request->getAttribute('id', '');

        $component = new EntityOverview();
        $filter = $request->getQueryParams();
        $entity = $component->getModel()->getEntity();
        $entity->clear();
        $entity->setParent($parent);
        $entity->from($filter);

        $params = $request->getQueryParams();

        if ($parent) {
            $params['mode'] = $params['mode'] ?? 'child';
        }

        $toolbar = new Toolbar();
        $toolbar->addButton('create')
            ->setEventAction()
            ->setMethod('POST')
            ->setUrl($this->uriBuilder->withCurrentUri()->withParams($params));
        $component->setToolbar($toolbar);

        #$request->getAttribute(Layout::class)->addTitle($component->getHeading());
        $this->renderer->setComponent($component);
        return new HtmlResponse($this->renderer->render());
    }
}
