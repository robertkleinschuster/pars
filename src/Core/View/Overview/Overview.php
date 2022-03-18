<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\{EntrypointInterface, Icon\Icon, ViewComponent, ViewModel, ViewRenderer};
use SplDoublyLinkedList;

class Overview extends ViewComponent implements EntrypointInterface
{
    public string $toolbar = '';
    public string $heading = '';
    protected OverviewField $buttons;
    protected ViewComponent $thead;
    protected ViewComponent $tbody;
    protected ViewComponent $trow;

    public function init()
    {
        parent::init();
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
        $this->buttons = $this->createField();
        $this->buttons->setTemplate(__DIR__ . '/templates/overview_buttons.phtml');
        $this->pushField($this->buttons);
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Overview.ts';
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
        $button = $this->createButton();
        $button->setContent($name);
        $this->buttons->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): OverviewButton
    {
        $button = $this->createButton();
        $button->push($icon);
        $this->buttons->push($button);
        return $button;
    }

    protected function createButton(): OverviewButton
    {
        return create(OverviewButton::class);
    }

    protected function createField(): OverviewField
    {
        return create(OverviewField::class);
    }

    public function addField(string $key, string $name = ''): OverviewField
    {
        $field = $this->createField();
        $field->setKey($key);
        $field->setName($name);
        $this->pushField($field);
        return $field;
    }

    protected function pushField(ViewComponent $field): static
    {
        $this->thead->push($field);
        $this->trow->push($field);
        return $this;
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
