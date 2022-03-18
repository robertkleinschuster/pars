<?php

namespace Pars\Core\View\Navigation;

use GuzzleHttp\Psr7\Uri;
use Pars\Core\View\Tree\TreeModel;

class NavigationModel extends TreeModel
{
    protected string $link = '';
    protected string $active = '';
    protected string $align = 'left';

    public function addEntry(string $name, string $link = ''): static
    {
        $model = new static();
        $model->setValue($name);
        $model->setLink($link);
        $this->push($model);
        return $model;
    }

    /**
     * @return string
     */
    public function getAlign(): string
    {
        return $this->align;
    }

    /**
     * @param string $align
     * @return NavigationModel
     */
    public function setAlign(string $align): NavigationModel
    {
        $this->align = $align;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return 'navigation-' . md5($this->link);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return NavigationModel
     */
    public function setLink(string $link): NavigationModel
    {
        $this->link = $link;
        return $this;
    }

    public function isActive(): bool
    {
        $currentUri = new Uri($_SERVER['REQUEST_URI']);
        $active = rtrim($this->link, '/') === rtrim($currentUri->getPath(), '/');
        if (!$active) {
            foreach ($this->getList() as $item) {
                if ($item->isActive()) {
                    return true;
                }
            }
        }
        return $active;
    }
}
