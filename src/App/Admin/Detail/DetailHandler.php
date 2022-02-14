<?php
namespace Pars\App\Admin\Detail;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\ViewComponent;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DetailHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return create(ClosureResponse::class, $this->renderDetail(...));
    }

    public function renderDetail(): string
    {
        $detail = new Detail();
        $field = new ViewComponent();
        $field->setContent('Field 1');
        $detail->push($field, 'Chapter 1', 'Group 1');

        $field = new ViewComponent();
        $field->setContent('Field 2');
        $detail->push($field, 'Chapter 1', 'Group 2');

        $field = new ViewComponent();
        $field->setContent('Field 3');
        $detail->push($field, 'Chapter 2', 'Group 1');

        $field = new ViewComponent();
        $field->setContent('Field 4');
        $detail->push($field, 'Chapter 2', 'Group 1');

        return render($detail);
    }

}