<?php

namespace Pars\App\Admin\Entity;

use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityPostHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $repo = new EntityRepository();
        $id = $request->getAttribute('id');
        if ($id) {
            $entity = $repo->findById($id);
        } else {
            $entity = new Entity();
        }

        $data = $request->getParsedBody();
        $entity->from($data);

        $repo->save($entity);

        return redirect_response(url(), 303);
    }
}
