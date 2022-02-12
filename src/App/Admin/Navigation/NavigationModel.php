<?php
namespace Pars\App\Admin\Navigation;

use Pars\Core\View\ViewModel;

class NavigationModel extends ViewModel
{
    protected string $link = '';
    protected string $active = '';

    public function addEntry(string $name, string $link): static
    {
        $model = new static();
        $model->setActive($this->active);
        $model->setValue($name);
        $model->setLink($link);
        $this->push($model);
        return $model;
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

    /**
     * @param string $active
     * @return NavigationModel
     */
    public function setActive(string $active): NavigationModel
    {
        $this->active = $active;
        return $this;
    }

    public function isActive(): bool
    {
        $active = rtrim($this->link, '/') === rtrim($this->active, '/');

        if (!$active) {
            foreach ($this as $item) {
                if ($item->isActive()) {
                    return true;
                }
            }
        }
        return $active;
    }


}