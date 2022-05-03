<?php

namespace Pars\App\Admin\User;

use Pars\Logic\User\User;
use Pars\Logic\User\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        if ($id) {
            return response(render((new UserDetail())->setId($id)));
        } else {
            return response(render(new UserOverview()));
        }
    }
}