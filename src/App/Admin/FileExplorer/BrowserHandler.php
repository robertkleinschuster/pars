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
        $file = $request->getQueryParams()['file'] ?? '';
        $browser = new Browser();
        $browser->getModel()->setValue($file);

        $browser->getDesktop()->getIcon()->setEventAction();
        $browser->getTree()->getItem()->setEventAction();
        #$event->url = $event->url->withPath('/browser/:file');
        return response(render($browser));
    }
}
