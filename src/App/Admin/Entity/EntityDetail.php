<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Editor\Editor;
use Pars\Core\View\Input\Input;
use Pars\Core\View\Select\Select;
use Pars\Core\View\ViewEvent;
use Pars\Core\View\ViewException;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\Info\EntityField;
use Pars\Logic\Entity\Info\EntityFieldInput;

/**
 * @method EntityModel getModel()
 */
class EntityDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new EntityModel();
        $this->setHeadingKey('{type:nameFallback}: {nameFallback}');
    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null): Input
    {
        $input = parent::addInput($key, $label, $chapter, $group);
        $input->model = $this->model;
        return $input;
    }

    /**
     * @throws ViewException
     * @throws EntityException
     */
    public function setId(string $id): static
    {
        $this->getModel()->setId($id);



        foreach ($this->getModel()->getFields() as $field) {
            if (empty($field->getCode()) && !$field->getViewOptions()->has(EntityField::VIEW_OPTION_DETAIL)) {
                continue;
            }
            $event = ViewEvent::action();
            $event->setMethod('POST');
            $event->setEvent('change');
            $event->setSelector("#{$field->getNormalizedCode()}");
            if ($field->getInput()->getType() === EntityFieldInput::TYPE_SELECT) {
                $select = new Select();
                $select->setEvent($event);
                $select->setId($field->getNormalizedCode());
                $select->setKey($field->getCode());
                $select->setLabel($field->getName());

                $value = $this->getValue($field->getCode());

                if ($value) {
                    $select->getModel()->setValue($value);
                }
                $select->addOption('', '-');

                foreach ($field->getOptions() as $key => $value) {
                    $select->addOption($key, $value);
                }
                $this->push($select, $field->getChapter(), $field->getGroup());
            } elseif ($field->getInput()->getType() === EntityFieldInput::TYPE_EDITOR) {
                $editor = new Editor();
                $editor->setEvent($event);
                $editor->setId($field->getNormalizedCode());
                $editor->setKey($field->getCode());
                $editor->setLabel($field->getName());
                $value = $this->getValue($field->getCode());
                if ($value) {
                    $editor->getModel()->setValue($value);
                }
                $this->push($editor, $field->getChapter(), $field->getGroup());
            } else {
                $this->addInput(
                    $field->getCode(),
                    $field->getName(),
                    $field->getChapter(),
                    $field->getGroup()
                )
                    ->setId($field->getNormalizedCode())
                    ->setType($field->getInput()->getType())
                    ->setDisabled($field->getInput()->isDisabled())
                    ->setEvent($event);
            }
        }

        return $this;
    }
}
