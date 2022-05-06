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
        $event = ViewEvent::action();
        $event->setMethod('POST');
        $event->setEvent('change');

        foreach ($this->getModel()->getFields() as $field) {
            if (empty($field->getCode())) {
                continue;
            }
            $this->addInput($field->getCode(), $field->getNameFallback())
                ->setEvent($event);
        }
        return $this;
    }

}
