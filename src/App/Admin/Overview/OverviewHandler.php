<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\Http\ClosureResponse;
use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
use Pars\Core\View\Toolbar\Toolbar;
use Pars\Core\View\ViewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OverviewHandler implements RequestHandlerInterface
{
    protected array $entries = [];
    protected array $fields = [];
    protected string $heading = '';
    protected string $entity = '';
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $entity = $request->getAttribute('entity');
        $this->entity = $request->getAttribute('entity');
        $this->entries[] = [
            'id' => 'first',
            'code' => 'first code',
        ];
        $this->entries[] = [
            'id' => 'second',
            'code' => 'second code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
        ];
        $this->entries[] = [
            'id' => 'third',
            'code' => 'third code',
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
        $overview = new Overview();
        $overview->getModel()->set('heading', $this->heading);
        foreach ($this->entries as $entry) {
            $model = new ViewModel();
            foreach ($entry as $key => $value) {
                $model->set($key, $value);
            }
            $overview->addEntry($model);
        }

        foreach ($this->fields as $field) {
            $overview->addField(__($field), $field)->setWindow(url("/{$this->entity}/:id"), __('detail'));
        }
        $toolbar = new Toolbar();
        $button = $toolbar->addIconButton(Icon::create());
        $button->setLink(url('/new'), __('new'))->target = 'blank';
        $overview->toolbar = render($toolbar);
        $button = $overview->addIconButton(Icon::delete());
        $button->setWindow(url('/delete'), __('delete'));
        return render($overview);
    }

}
