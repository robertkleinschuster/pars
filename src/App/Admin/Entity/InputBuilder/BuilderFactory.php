<?php

namespace Pars\App\Admin\Entity\InputBuilder;

use Pars\Logic\Entity\Info\EntityField;
use Pars\Logic\Entity\Info\EntityFieldInput;

class BuilderFactory
{
    private static $inputTypes = [
        EntityFieldInput::TYPE_TEXT => TextBuilder::class,
        EntityFieldInput::TYPE_NUMBER => NumberBuilder::class,
        EntityFieldInput::TYPE_CHECKBOX => CheckboxBuilder::class,
        EntityFieldInput::TYPE_EDITOR => EditorBuilder::class,
        EntityFieldInput::TYPE_SELECT => SelectBuilder::class
    ];

    public static function create(EntityField $field): BaseBuilder
    {
        $class = self::$inputTypes[$field->getInput()->getType()] ?? TextBuilder::class;
        return new $class($field);
    }


}
