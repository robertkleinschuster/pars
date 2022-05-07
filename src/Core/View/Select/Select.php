<?php

namespace Pars\Core\View\Select;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;

class Select extends FormViewComponent implements EntrypointInterface
{
    private ViewComponent $option;

    protected function init()
    {
        parent::init();
        $this->option = new ViewComponent();
        $this->option->setTemplate(__DIR__ . '/templates/select_option.phtml');
        $this->option->setTag('option');
        $this->push($this->option);
        $this->setTemplate(__DIR__ . '/templates/select.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Select.ts';
    }

    /**
     * @return ViewComponent
     */
    public function getOption(): ViewComponent
    {
        return $this->option;
    }

    public function addOption(string $key, string $value): self
    {
        $model = new ViewModel();
        $model->setValue($value);
        $model->set('key', $key);
        $this->getOption()->getModel()->push($model);
        return $this;
    }
}
