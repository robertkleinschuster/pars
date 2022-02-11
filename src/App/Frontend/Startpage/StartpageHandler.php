<?php
namespace Pars\App\Frontend\Startpage;

use GuzzleHttp\Psr7\Response;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        ob_start();
        require_once 'templates/startpage.phtml';
        return new Response(200, [], new ClosureStream(ob_get_clean(...)));
    }

}