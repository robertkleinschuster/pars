<?php

namespace Pars\App\Frontend\Startpage;

use Pars\Core\Http\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    protected string $heading;
    protected string $teaser;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->heading = 'Startpage';
        $this->teaser = 'lorem ipsum dolor sit amet';
        return create(HtmlResponse::class, $this->render());
    }

    public function render()
    {
        ob_start();
        include 'templates/startpage.phtml';
        return ob_get_clean();
    }
}
