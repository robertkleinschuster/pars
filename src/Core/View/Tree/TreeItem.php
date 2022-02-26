<?php
namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewEvent;
use Pars\Core\View\ViewRenderer;

/**
 * @method TreeModel getModel
 * @property TreeModel $model
 */
class TreeItem extends ViewComponent
{
    protected Tree $tree;
    protected string $treeClass = Tree::class;

    public function __construct()
    {
        parent::__construct();
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
        if ($this->getContent()) {
            return null;
        }
        return parent::getEvent();
    }


    public function getTree(): Tree {
        if (!isset($this->tree)) {
            $this->tree = create($this->getTreeClass());
        }
        return $this->tree;
    }


}