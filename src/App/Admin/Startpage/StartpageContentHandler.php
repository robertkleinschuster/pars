<?php
namespace Pars\App\Admin\Startpage;

use Pars\Core\Http\HtmlResponse;
use Pars\Core\View\Overview\Overview;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageContentHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $overview = new Overview();
        $overview->setHeading('overview heading');

        return create(HtmlResponse::class, render($overview, $this));
    }

}