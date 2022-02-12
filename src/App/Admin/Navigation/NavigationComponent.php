<?php
namespace Pars\App\Admin\Navigation;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;

class NavigationComponent extends ViewComponent
{
    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/navigation.phtml');
    }

    public function addEntry(string $name, string $link): static
    {
        $model = new ViewModel();
        $model->setValue($name);
        $model->set('link', $link);
        $this->getModel()->push($model);
        return $this;
    }
}