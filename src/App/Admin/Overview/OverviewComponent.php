<?php

namespace Pars\App\Admin\Overview;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use SplDoublyLinkedList;

/**
 * @method OverviewModel getModel()
 */
class OverviewComponent extends ViewComponent
{
    public string $toolbar = '';
    protected SplDoublyLinkedList $buttons;
    protected ViewComponent $thead;
    protected ViewComponent $tbody;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/overview.phtml');
        $this->buttons = new SplDoublyLinkedList();
        $this->model = new OverviewModel();
        $this->thead = new ViewComponent();
        $this->tbody = new ViewComponent();
        $this->thead->setTemplate(__DIR__ . '/templates/overview_head.phtml');
        $this->tbody->setTemplate(__DIR__ . '/templates/overview_body.phtml');
        $this->push($this->thead);
        $this->push($this->tbody);
    }

    public function getButtons(): SplDoublyLinkedList
    {
        return $this->buttons;
    }

    public function addButton(string $name): OverviewButtonComponent
    {
        $button = new OverviewButtonComponent();
        $button->setContent($name);
        $this->buttons->push($button);
        return $button;
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