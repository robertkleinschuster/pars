<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Select\Select;
use Pars\Core\View\ViewEvent;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;

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
            $select = $field->getDataArray()['select'] ?? null;
            if ($select) {
                $entity = new Entity();
                $entity->from($select);
                $repo = new EntityRepository();

                $select = new Select();
                $select->setEvent($event);
                $select->setKey($field->getCode());
                $select->setLabel($field->getNameFallback());

                $value = $this->getValue($field->getCode());

                if ($value) {
                    $select->getModel()->setValue($value);
                }
                $select->addOption('', ' -');
                foreach ($repo->find($entity) as $option) {
                    $select->addOption($option->getCode(), $option->getNameFallback());
                }
                $this->push($select);
            } else {
                $this->addInput($field->getCode(), $field->getNameFallback())
                    ->setEvent($event);
            }
        }
        return $this;
    }

}
