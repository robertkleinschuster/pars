<?php

namespace Pars\App\Admin\Entity\Overview;

use Pars\App\Admin\Entity\EntityInputBuilder;
use Pars\App\Admin\Entity\EntityModel;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\View\Icon\Icon;
use Pars\Core\View\Overview\Overview;

use function url;

/**
 * @method EntityModel getModel()()
 */
class EntityOverview extends Overview
{
    public function init()
    {
        parent::init();
        $this->model = new EntityModel();
        $this->setHeading('{type:nameFallback}');

        $this->addIconButton(Icon::edit())
            ->setEventLink('/:id');

        $this->addIconButton(Icon::delete())
            ->setEventAction()
            ->setUrl('/:id')
            ->setMethod('DELETE');

        $this->pushField(new EntityOverviewField());
    }
}
