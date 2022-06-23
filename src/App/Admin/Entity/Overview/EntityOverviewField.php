<?php

namespace Pars\App\Admin\Entity\Overview;

use Pars\App\Admin\Entity\EntityModel;
use Pars\Core\View\Overview\OverviewField;
use Pars\Core\View\ViewRenderer;
use Pars\Logic\Entity\Info\EntityField;

class EntityOverviewField extends OverviewField
{
    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $model = $this->getModel();
        $hasInput = false;
        if ($model instanceof EntityModel) {
            if ($model->getId()) {
                foreach ($model->buildInputs(EntityField::VIEW_OPTION_OVERVIEW, true) as $input) {
                    $this->push($input);
                    $hasInput = true;
                }
            } else {
                foreach ($model->buildInputs(EntityField::VIEW_OPTION_OVERVIEW_HEAD, true) as $input) {
                    unset($input->model);
                    #$this->push($input);
                    $hasInput = true;
                }
                unset($this->model);
            }
        }
        if (!$hasInput) {
            $this->setKey('code');
        }
    }
}
