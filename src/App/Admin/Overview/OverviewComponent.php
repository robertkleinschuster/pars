<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;

/**
 * @method OverviewModel getModel()
 */
class OverviewComponent extends ViewComponent
{

    protected ViewComponent $thead;
    protected ViewComponent $tbody;

    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/overview.phtml');
        $this->model = new OverviewModel();
        $this->thead = new ViewComponent();
        $this->tbody = new ViewComponent();
        $this->thead->setTemplate(__DIR__ . '/templates/overview_head.phtml');
        $this->tbody->setTemplate(__DIR__ . '/templates/overview_body.phtml');
        $this->push($this->thead);
        $this->push($this->tbody);
    }


    public function addField(string $name, string $key): OverviewFieldComponent
    {
        $field = new OverviewFieldComponent($key, $name);
        $this->thead->push($field);
        $this->tbody->push($field);
        return $field;
    }

    public function addEntry(ViewModel $model)
    {
        $this->tbody->getModel()->push($model);
        return $this;
    }

}