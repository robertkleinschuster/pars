<?php

namespace Pars\App\Admin\Entity;

use Pars\Logic\Entity\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityDeleteHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $repo = new EntityRepository();
        $id = explode('/', $request->getAttribute('id', ''));

        $repo->delete($repo->findById(array_pop($id)));
        return redirect_response($request->getHeaderLine('Referer'), 303);
    }

}