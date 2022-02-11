<?php
namespace Pars\App\Admin;

use GuzzleHttp\Psr7\Response;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends AbstractApplication implements PathApplicationInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], 'admin');
    }

    public function getPath(): string
    {
        return '/admin';
    }
}