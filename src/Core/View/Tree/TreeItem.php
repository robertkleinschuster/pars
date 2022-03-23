<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\{ViewComponent, ViewEvent, ViewRenderer};

/**
 * @method TreeModel getModel()
 * @property TreeModel $model
 */
class TreeItem extends ViewComponent
{
    protected Tree $tree;
    protected string $treeClass = Tree::class;

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/tree_item.phtml');
        $this->model = create(TreeModel::class);
    }

    /**
     * @return string
     */
    public function getTreeClass(): string
    {
        return $this->treeClass;
    }

    /**
     * @param string $treeClass
     * @return TreeItem
     */
    public function setTreeClass(string $treeClass): TreeItem
    {
        $this->treeClass = $treeClass;
        return $this;
    }


    public function addEntry(string $value, ...$params): TreeModel
    {
        return $this->getModel()->addEntry($value, ...$params);
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if ($this->isList()) {
            $this->getTree()->getItem()->model = $this->model;
            $this->getTree()->getItem()->setEvent($this->getEvent());
            $this->push($this->getTree());
        }
    }

    public function getEvent(): ?ViewEvent
    {
        if ($this->hasItems()) {
            return null;
        }
        return parent::getEvent();
    }

    public function getTree(): Tree
    {
        if (!isset($this->tree)) {
            $this->tree = create($this->getTreeClass());
        }
        return $this->tree;
    }

    public function hasItems(): bool
    {
        return !empty($this->getContent());
    }
}
