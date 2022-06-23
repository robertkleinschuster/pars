<?php

namespace Pars\App\Admin\Entity\Detail;

use Pars\App\Admin\Entity\EntityModel;
use Pars\Core\View\Detail\Detail;
use Pars\Core\View\Input\Input;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\Info\EntityField;

/**
 * @method EntityModel getModel()
 */
class EntityDetail extends Detail
{
    protected function init()
    {
        parent::init();
        $this->model = new EntityModel();
        $this->setHeadingKey('{type:nameFallback}: {nameFallback}');
    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null): Input
    {
        $input = parent::addInput($key, $label, $chapter, $group);
        $input->model = $this->model;
        return $input;
    }

    /**
     * @throws EntityException
     */
    public function setId(string $id): static
    {
        $model = $this->getModel();
        $model->setId($id);

        $this->setHeadingKey($this->getModel()->get('type:heading') ?? $this->getHeadingKey());

        foreach ($model->buildInputs(EntityField::VIEW_OPTION_DETAIL) as $input) {
            $this->push($input);
        }

        return $this;
    }
}
