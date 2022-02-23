<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class Tree extends ViewComponent
{
    protected TreeItem $item;
    protected string $itemClass = TreeItem::class;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/tree.phtml');
    }

    /**
     * @return string
     */
    public function getItemClass(): string
    {
        return $this->itemClass;
    }

    /**
     * @param string $itemClass
     * @return Tree
     */
    public function setItemClass(string $itemClass): Tree
    {
        $this->itemClass = $itemClass;
        return $this;
    }


    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        if ($this->getItem()->isList()) {
            $this->push($this->getItem());
        }
    }

    public function addEntry(string $value, ...$params): TreeModel
    {
        return $this->getItem()->addEntry($value, ...$params);
    }

    public function getItem(): TreeItem
    {
        if (!isset($this->item)) {
            $this->item = create($this->getItemClass());
        }
        return $this->item;
    }
}