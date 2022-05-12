<?php

namespace Pars\App\Admin\Entity;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\EntityUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityPostHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        (new EntityUpdater())->update();

        $params = $request->getQueryParams();
        $repo = new EntityRepository();
        $id = explode('/', $request->getAttribute('id'));
        $id = array_pop($id);
        $mode = $params['mode'] ?? null;
        unset($params['mode']);
        if ($id) {
            $entity = $repo->findById($id);
        } else {
            $entity = new Entity();
        }

        if ('child' === $mode) {
            $entity->setId('');
            $entity->setCode('');
            $entity->setName('');
            $entity->setDataArray([]);
            $entity->setParent($id);
        }
        
        $entity->from($params);
        $entity->from($request->getParsedBody());

        $repo->save($entity);

        return redirect_response(url()->withParams($params), 303);
    }
}
