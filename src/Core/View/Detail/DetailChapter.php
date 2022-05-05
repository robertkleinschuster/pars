<?php

namespace Pars\Core\View\Detail;

use Pars\Core\View\ViewComponent;

class DetailChapter extends ViewComponent
{
    use GroupTrait;

    protected string $name = '';



    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/detail_chapter.phtml');
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DetailChapter
     */
    public function setName(string $name): DetailChapter
    {
        $this->name = $name;
        return $this;
    }

    public function push(ViewComponent $component, string $group = null): static
    {
        if (null !== $group) {
            $this->getGroup($group)->push($component);
        } else {
            parent::push($component);
        }
        return $this;
    }
}
