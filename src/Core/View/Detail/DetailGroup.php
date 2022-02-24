<?php

namespace Pars\Core\View\Detail;

use Pars\Core\View\ViewComponent;

class DetailGroup extends ViewComponent
{
    protected string $name = '';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/detail_group.phtml');
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
     * @return DetailGroup
     */
    public function setName(string $name): DetailGroup
    {
        $this->name = $name;
        return $this;
    }


}