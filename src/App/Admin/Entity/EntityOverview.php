<?php

namespace Pars\App\Admin\Entity;

use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;
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

        $this->addField('type', 'type');
        $this->addField('state', 'state');
        $this->addField('context', 'context');
        $this->addField('language', 'language');
        $this->addField('country', 'country');
        $this->addField('code', 'code');
        $this->addField('name', 'name');
    }
}
