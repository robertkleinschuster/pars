<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\ViewEvent;

/**
 * @method EntityModel getModel()
 */
class EntityDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new EntityModel();
        $event = ViewEvent::action();
        $event->setMethod('POST');
        $event->setEvent('change');

        $this->addInput('type', 'type', 'props')
            ->setEvent($event);
        $this->addInput('state', 'state', 'props')
            ->setEvent($event);
        $this->addInput('context', 'context', 'props')
            ->setEvent($event);

        $this->addInput('language', 'language', 'locale')
            ->setEvent($event);

        $this->addInput('country', 'country', 'locale')
            ->setEvent($event);
        $this->addInput('code', 'code', 'info')
            ->setEvent($event);
        $this->addInput('name', 'name', 'info')
            ->setEvent($event);

    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null)
    {
        $input = parent::addInput($key, $label, $chapter, $group);
        $input->model = $this->model;
        return $input;
    }

    public function setId(string $id)
    {
        $this->getModel()->setId($id);
        return $this;
    }
}
