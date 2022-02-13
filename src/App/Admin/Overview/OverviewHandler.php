<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewEvent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OverviewHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entity = $request->getAttribute('entity');
        return create(ClosureResponse::class, $this->renderOverview(...));
    }

    public function renderOverview()
    {
        $overview = new OverviewComponent();
        $overview->addField('foo', 'foo');
        $event = new ViewEvent();
        $event->handler = static::class;
        $event->url = url('/test/:id');
        $overview->addField('bar', 'bar')->setEvent($event);
        
        $entry = new ViewModel();
        $entry->set('foo', 'test');
        $entry->set('id', '1');
        $entry->set('bar', 'test');
        $overview->addEntry($entry);

        $entry = new ViewModel();
        $entry->set('id', '2');
        $entry->set('foo', 'test');
        $entry->set('bar', 'test2');
        $overview->addEntry($entry);

        $entry = new ViewModel();
        $entry->set('foo', 'test 3');
        $entry->set('bar', 'test3');
        $overview->addEntry($entry);


        $renderer = new ViewRenderer();
        $renderer->setComponent($overview);
        return $renderer->render();
    }

}