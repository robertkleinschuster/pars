<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
use Pars\Logic\Entity\Type\Definition\TypeField;

/**
 * @method EntityModel getRowModel()
 */
class EntityOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->setRowModel(new EntityModel());

        $this->addIconButton(Icon::edit())
            ->setEventLink(url('/entity/:id'));

        $this->addIconButton(Icon::delete())
            ->setEventAction()
            ->setUrl(url('/entity/:id'))
            ->setMethod('DELETE');
    }

    public function initFields()
    {
        if ($this->getRowModel()->getEntity()->getType()) {
            $type = $this->getRowModel()->getEntityType();

            foreach ($type->getInfo()->getFields() as $field) {
                if ($field->getViewOptions()->has(TypeField::VIEW_OPTION_OVERVIEW)) {
                    $this->addField($field->getCode(), $field->getName());
                }
            }
        } else {
            $this->addField('context', 'context');
            $this->addField('type', 'type');
            $this->addField('code', 'code');
            $this->addField('name', 'name');
        }
    }
}
