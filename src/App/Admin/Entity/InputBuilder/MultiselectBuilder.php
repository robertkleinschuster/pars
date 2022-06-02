<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\FormViewComponent;
use Pars\Core\View\Multiselect\Multiselect;

class MultiselectBuilder extends BaseBuilder
{
    public function build(): FormViewComponent
    {
        $field = $this->getField();
        $multiselect = new Multiselect();
        $multiselect->setEvent($this->createEvent());
        $multiselect->setId($this->getId());
        $multiselect->setKey($field->getCode());
        $multiselect->setLabel($field->getName());
        $multiselect->setFullwidth($field->isFullwidth());
        foreach ($field->getOptions() as $key => $value) {
            $multiselect->addValue($key, $value);
        }

        return $multiselect;
    }
}
