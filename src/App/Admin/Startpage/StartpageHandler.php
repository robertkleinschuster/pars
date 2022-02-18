<?php
namespace Pars\App\Admin\Startpage;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\Http\HtmlResponse;
use Pars\Core\Session\SessionTrait;
use Pars\Core\View\Detail\Detail;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartpageHandler implements RequestHandlerInterface
{
    use SessionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $detail = new Detail();
        $detail->addInput('test', 'test')->setWindow(url('/test'), 'title');
        return create(HtmlResponse::class, render($detail));
        return create(ClosureResponse::class, $this->renderTemplate(...));
    }

    public function renderTemplate()
    {
        ob_start();
        include "templates/startpage.phtml";
        return ob_get_clean();
    }
}