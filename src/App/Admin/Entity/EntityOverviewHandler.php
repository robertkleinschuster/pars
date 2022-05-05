<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Toolbar\Toolbar;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityOverviewHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parent = $request->getAttribute('id', '');

        $component = new EntityOverview();
        $filter = $request->getQueryParams();
        $entity = $component->getRowModel()->getEntity();
        $entity->clear();
        $entity->setParent($parent);
        $entity->from($filter);

        $params = $request->getQueryParams();
        if ($parent) {
            $params['mode'] = 'child';
        }

        $toolbar = new Toolbar();
        $toolbar->addButton('create')
            ->setEventAction()
            ->setMethod('POST')
            ->setUrl(url()->withParams($params));
        $component->setToolbar(render($toolbar));

        return response(render($component));
    }
}
