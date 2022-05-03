<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\ViewEvent;

/**
 * @method UserModel getModel()
 */
class UserDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new UserModel();
        $event = ViewEvent::action('');
        $event->event = 'change';
        $event->method = 'POST';
        $input = $this->addInput('name', 'Name');
        $input->model = $this->model;
        $input->setEvent($event);
    }

    public function setId(string $id): self
    {
        $this->getModel()->setId($id);
        return $this;
    }
}