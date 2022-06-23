<?php

namespace Pars\Core\View\Overview;

use Pars\Core\View\{EntrypointInterface, Entrypoints, Icon\Icon, ViewComponent, ViewModel, ViewRenderer};
use Psr\Http\Message\StreamInterface;

class Overview extends ViewComponent implements EntrypointInterface
{
    private string|StreamInterface|ViewComponent $toolbar = '';
    private string|StreamInterface|ViewComponent $heading = '';

    private OverviewHead $head;
    private OverviewItem $item;
    private OverviewButtonField $buttons;

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Overview.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Overview.ts';
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);

        if ($this->heading instanceof ViewComponent) {
            $this->heading = $renderer->setComponent($this->heading)->render();
        }

        $this->heading = $this->getFormatter()->format($this->heading, $this->getModel());

        if ($this->toolbar instanceof ViewComponent) {
            $this->toolbar = $renderer->setComponent($this->toolbar)->render();
        }

        if (isset($this->buttons)) {
            $this->getItem()->getChildren()->unshift($this->buttons);
        }

        if (isset($this->head)) {
            $this->head->model = $this->getModel();
            $this->push($this->head);
        }

        if (isset($this->item)) {
            $this->item->model = $this->getModel();
            $this->push($this->item);
        }
        unset($this->model);
    }

    /**
     * @return OverviewButtonField
     */
    public function getButtons(): OverviewButtonField
    {
        if (!isset($this->buttons)) {
            $this->buttons = new OverviewButtonField();
        }
        return $this->buttons;
    }

    /**
     * @param OverviewButtonField $buttons
     * @return OverviewItem
     */
    public function setButtons(OverviewButtonField $buttons): OverviewItem
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function addButton(string $name): OverviewButton
    {
        $button = new OverviewButton();
        $button->setContent($name);
        $this->getButtons()->push($button);
        return $button;
    }

    public function addIconButton(Icon $icon): OverviewButton
    {
        $button = new OverviewButton();
        $button->push($icon);
        $this->getButtons()->push($button);
        return $button;
    }

    public function addField(string $key, string $name = ''): OverviewField
    {
        $field = new OverviewField();
        $field->setKey($key);
        $field->setName($name);
        $this->pushField($field);
        return $field;
    }

    protected function pushField(ViewComponent $field): static
    {
        $this->getHead()->push($field);
        $this->getItem()->push($field);
        return $this;
    }

    public function addEntry(ViewModel $model): static
    {
        $this->getModel()->push($model);
        return $this;
    }

    /**
     * @return string|StreamInterface|ViewComponent
     */
    public function getToolbar(): string|StreamInterface|ViewComponent
    {
        return $this->toolbar;
    }

    /**
     * @param string|StreamInterface|ViewComponent $toolbar
     * @return Overview
     */
    public function setToolbar(string|StreamInterface|ViewComponent $toolbar): Overview
    {
        $this->toolbar = $toolbar;
        return $this;
    }

    /**
     * @return string|StreamInterface|ViewComponent
     */
    public function getHeading(): string|StreamInterface|ViewComponent
    {
        return $this->heading;
    }

    /**
     * @param string|StreamInterface|ViewComponent $heading
     * @return Overview
     */
    public function setHeading(string|StreamInterface|ViewComponent $heading): Overview
    {
        $this->heading = $heading;
        return $this;
    }

    /**
     * @return OverviewHead
     */
    protected function getHead(): OverviewHead
    {
        if (!isset($this->head)) {
            $this->head = new OverviewHead();
        }
        return $this->head;
    }

    /**
     * @return OverviewItem
     */
    protected function getItem(): OverviewItem
    {
        if (!isset($this->item)) {
            $this->item = new OverviewItem();
        }
        return $this->item;
    }
}
