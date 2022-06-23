<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\{ViewComponent, ViewEvent, ViewRenderer};

/**
 * @method TreeModel getModel()
 */
class TreeItem extends ViewComponent
{

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/tree_item.phtml');
    }


    public function addEntry(string $value, ...$params): TreeModel
    {
        return $this->getModel()->addEntry($value, ...$params);
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $model = $this->getModel();
        if ($model->isList()) {
            $this->push($this->getParent()->withModel($model)->clearChildren());
        }
    }

    public function isList(): bool
    {
        return false;
    }

    public function getEvent(): ?ViewEvent
    {
        if ($this->hasItems()) {
            return null;
        }
        return parent::getEvent();
    }

    public function hasItems(): bool
    {
        return !empty($this->getContent());
    }
}
