<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Core\View\Editor\Editor;
use Pars\Core\View\FormViewComponent;

class EditorBuilder extends BaseBuilder
{
    public function build(): FormViewComponent
    {
        $field = $this->getField();
        $editor = new Editor();
        $editor->setEvent($this->createChangeEvent());
        $editor->setId($this->getId());
        $editor->setKey($field->getCode());
        $editor->setLabel($field->getName());
        return $editor;
    }

}
