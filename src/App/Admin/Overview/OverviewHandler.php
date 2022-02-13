<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
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

        $renderer = new ViewRenderer();
        $renderer->setComponent($overview);
        return $renderer->render();
    }

}