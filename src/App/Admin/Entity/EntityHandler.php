<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Toolbar\Toolbar;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        if ($id) {
            $component = new EntityDetail();
            $component->setId($id);
        } else {
            $component = new EntityOverview();
            $filter = $request->getQueryParams();
            $entity = $component->getRowModel()->getEntity();
            $entity->clear();
            $entity->from($filter);

            $toolbar = new Toolbar();
            $toolbar->addButton('create')
                ->setEventAction()->method = 'POST';
            $component->setToolbar(render($toolbar));
        }
        return response(render($component));
    }
}
