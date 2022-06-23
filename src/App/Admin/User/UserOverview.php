<?php

namespace Pars\App\Admin\User;

use Pars\Core\View\Overview\Overview;

class UserOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->model = new UserModel();
        $this->addField('name')->setEventLink(url('/user/:id'));
    }
}
