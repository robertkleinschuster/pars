<?php

namespace Pars\Core\View\Tree;

use Pars\Core\View\{EntrypointInterface, ViewComponent, ViewModel, ViewRenderer};
use Psr\Http\Message\StreamInterface;

/**
 * @method TreeModel getModel()
 * @property TreeModel $model
 */
class Tree extends ViewComponent implements EntrypointInterface
{
    protected TreeItem $item;
    protected string $itemClass = TreeItem::class;
    protected string $heading = '';
    protected string $baseUri = '';
    protected ?StreamInterface $toolbar = null;

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/tree.phtml');
        $this->model = create(TreeModel::class);
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Tree.ts';
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
        foreach ($this->getModel() as $item) {
            $this->push($this->getItem()->withModel($item));
        }
    }

    public function isList(): bool
    {
        return false;
    }

    public function addEntry(string $value, ...$params): TreeModel
    {
        return $this->getModel()->addEntry($value, ...$params);
    }

    public function setModel(ViewModel $model)
    {
        $this->model = $model;
        return $this;
    }

    public function getItem(): TreeItem
    {
        if (!isset($this->item)) {
            $this->item = create($this->getItemClass());
        }
        return $this->item;
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
     * @return Tree
     */
    public function setHeading(string $heading): Tree
    {
        $this->heading = $heading;
        return $this;
    }

    /**
     * @param StreamInterface|null $toolbar
     * @return Tree
     */
    public function setToolbar(?StreamInterface $toolbar): Tree
    {
        $this->toolbar = $toolbar;
        return $this;
    }

    /**
     * @return StreamInterface|null
     */
    public function getToolbar(): ?StreamInterface
    {
        return $this->toolbar;
    }

    public function isRoot(): bool
    {
        return !$this->parent instanceof TreeItem;
    }

    protected function attr(): string
    {
        $result = parent::attr();
        if ($this->baseUri) {
            $result .= " data-base-uri='{$this->baseUri}'";
        }
        return $result;
    }

    /**
     * @param string $baseUri
     * @return Tree
     */
    public function setBaseUri(string $baseUri): Tree
    {
        $this->baseUri = $baseUri;
        return $this;
    }
}
