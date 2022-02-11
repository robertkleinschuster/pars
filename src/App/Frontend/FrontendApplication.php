<?php
namespace Pars\App\Frontend;

use GuzzleHttp\Psr7\Response;
use Pars\Core\Application\Base\AbstractApplication;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FrontendApplication extends AbstractApplication
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], 'frontend');
    }
}