<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
use Pars\Logic\Entity\Info\EntityField;

/**
 * @method EntityModel getRowModel()
 */
class EntityOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->setRowModel(new EntityModel());
        $link = url('/')->withAppendedPath('/:id');

        $this->addIconButton(Icon::edit())
            ->setEventLink($link);

        $this->addIconButton(Icon::delete())
            ->setEventAction()
            ->setUrl($link)
            ->setMethod('DELETE');
    }

    public function initFields()
    {
        if ($this->getRowModel()->getEntity()->getType()) {
            $type = $this->getRowModel()->getType();

            foreach ($type->getInfo()->getFields() as $field) {
                if ($field->getViewOptions()->has(EntityField::VIEW_OPTION_OVERVIEW)) {
                    $this->addField($field->getCode(), $field->getName());
                }
            }
        } else {
            $this->addField('type', 'type');
            $this->addField('code', 'code');
            $this->addField('name', 'name');
        }
    }
}
