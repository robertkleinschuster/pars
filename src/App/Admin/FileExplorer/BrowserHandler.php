<?php

namespace Pars\App\Admin\FileExplorer;

use Pars\Core\View\Browser\Browser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BrowserHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $browser = new Browser();
        $event = $browser->getDesktop()->getIcon()->setEventAction();
        #$event->url = $event->url->withPath('/browser/:file');
        return response(render($browser));
    }
}
