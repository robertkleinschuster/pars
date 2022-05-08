<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
use Pars\Core\View\ViewRenderer;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityRepository;
use Pars\Logic\Entity\EntityUpdater;

/**
 * @method EntityModel getRowModel()
 */
class EntityOverview extends Overview
{
    public function init()
    {
        parent::init();
        (new EntityUpdater())->update();
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
        $entity = $this->getRowModel()->getEntity();
        if ($entity->getType()) {
            $filterEntity = new Entity();
            $filterEntity->setType(Entity::TYPE_TYPE);
            $filterEntity->setCode($entity->getType());
            $repo = new EntityRepository();
            $type = $repo->find($filterEntity)->current();
            if ($type) {
                $this->setHeading($type->getName());
            }

            $filterEntity = new Entity();
            $filterEntity->setType(Entity::TYPE_GROUP);
            $filterEntity->setCode($entity->getGroup());
            $repo = new EntityRepository();
            $group = $repo->find($filterEntity)->current();
            if ($group) {
                $this->setHeading($group->getName() . ': ' . $this->getHeading());
            }

            foreach ($this->getRowModel()->getFields() as $field) {
                if ($field->findDataByFormKey(Entity::DATA_OVERVIEW_SHOW)) {
                    $this->addField($field->getCode(), $field->getNameFallback());
                }
            }
        } else {
            $this->addField('type', 'type');
            $this->addField('code', 'code');
            $this->addField('name', 'name');
            $this->addField('context', 'context');
        }
    }
}
