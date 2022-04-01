<?php

namespace Pars\App\Admin\Overview;

use Pars\Core\View\Overview\Overview;
use Pars\Core\View\ViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OverviewHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $overview = new Overview();
        $overview->addField('id', 'id');
        $overview->addButton('action')->setEventAction('action');
        $overview->addButton('window')->setEventWindow(url('/'), 'window');
        $model = new ViewModel();
        $model->set('id', '1');
        $overview->addEntry($model);
        $model = new ViewModel();
        $model->set('id', '2');
        $overview->addEntry($model);
        $model = new ViewModel();
        $model->set('id', '3');
        $overview->addEntry($model);
        return response(render($overview));
    }
}
