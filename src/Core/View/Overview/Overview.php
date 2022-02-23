<?php
namespace Pars\Core\View\Overview;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;
use SplDoublyLinkedList;

class Overview extends ViewComponent
{
    public string $toolbar = '';
    public string $heading = '';
    protected OverviewField $buttons;
    protected ViewComponent $thead;
    protected ViewComponent $tbody;
    protected ViewComponent $trow;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/overview.phtml');
        $this->thead = create(ViewComponent::class);
        $this->tbody = create(ViewComponent::class);
        $this->trow = create(ViewComponent::class);
        $this->thead->setTemplate(__DIR__ . '/templates/overview_head.phtml');
        $this->tbody->setTag('tbody');
        $this->trow->setTag('tr');
        $this->push($this->thead);
        $this->push($this->tbody);
        $this->tbody->push($this->trow);
        $this->buttons = $this->addField('');
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if (!$this->trow->getModel()->isList()) {
            $this->children = new SplDoublyLinkedList();
        }
    }

    public function addButton(string $name): OverviewButton
    {
        $button = create(OverviewButton::class);
        $button->setContent($name);
        $this->buttons->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): OverviewButton
    {
        $button = create(OverviewButton::class);
        $button->push($icon);
        $this->buttons->push($button);
        return $button;
    }


    public function addField(string $key, string $name = ''): OverviewField
    {
        $field = create(OverviewField::class, $key, $name);
        $this->thead->push($field);
        $this->trow->push($field);
        return $field;
    }

    public function addEntry(ViewModel $model): static
    {
        $this->trow->getModel()->push($model);
        return $this;
    }

    /**
     * @return string
     */
    public function getToolbar(): string
    {
        return $this->toolbar;
    }

    /**
     * @param string $toolbar
     * @return Overview
     */
    public function setToolbar(string $toolbar): Overview
    {
        $this->toolbar = $toolbar;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     * @return Overview
     */
    public function setHeading(string $heading): Overview
    {
        $this->heading = $heading;
        return $this;
    }


}