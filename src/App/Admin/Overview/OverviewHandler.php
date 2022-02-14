<?php
namespace Pars\App\Admin\Overview;

use Pars\App\Admin\Toolbar\ToolbarComponent;
use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\ViewEvent;
use Pars\Core\View\ViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OverviewHandler implements RequestHandlerInterface
{
    protected array $entries = [];
    protected array $fields = [];
    protected string $heading = '';

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entity = $request->getAttribute('entity');
        $this->entries[] = [
            'id' => 'first'
        ];
        $this->entries[] = [
            'id' => 'second'
        ];
        $this->entries[] = [
            'id' => 'third'
        ];
        $this->fields[] = 'id';
        $this->fields[] = 'code';
        if ($entity) {
            $this->heading = __($entity . '.overview');
        } else {
            $this->heading = __('overview');
        }
        return create(ClosureResponse::class, $this->renderOverview(...));
    }

    public function renderOverview()
    {
        $overview = new OverviewComponent();
        $overview->getModel()->set('heading', $this->heading);
        foreach ($this->entries as $entry) {
            $model = new ViewModel();
            foreach ($entry as $key => $value) {
                $model->set($key, $value);
            }
            $overview->addEntry($model);
        }

        foreach ($this->fields as $field) {
            $overview->addField(__($field), $field);
        }
        $toolbar = new ToolbarComponent();
        $toolbar->addButton(__('new'));
        $overview->toolbar = render($toolbar);
        $event  = new ViewEvent();
        $event->url = url('/test');
        $event->target = ViewEvent::TARGET_WINDOW;
        $event->title = __('edit');
        $event->handler = static::class;
        $overview->addButton(__('edit'))->setEvent($event);
        $event  = new ViewEvent();
        $event->url = url('/test');
        $event->target = ViewEvent::TARGET_ACTION;
        $event->title = __('delete');
        $event->handler = static::class;
        $overview->addButton(__('delete'))->setEvent($event);
        return render($overview);
    }

}
