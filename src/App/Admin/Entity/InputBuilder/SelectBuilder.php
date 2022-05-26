<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\FormViewComponent;
use Pars\Core\View\Select\Select;

class SelectBuilder extends BaseBuilder
{
    public function build(): FormViewComponent
    {
        $field = $this->getField();
        $select = new Select();
        $select->setEvent($this->createEvent());
        $select->setId($this->getId());
        $select->setKey($field->getCode());
        $select->setLabel($field->getName());


        $select->addOption('', '-');

        foreach ($field->getOptions() as $key => $value) {
            $select->addOption($key, $value);
        }

        return $select;
    }
}
