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

        $this->addField('context', 'context');
        $this->addField('type', 'type');
        $this->addField('code', 'code');
        $this->addField('name', 'name');

        if ($entity->getType()) {

        } else {

        }
    }
}
