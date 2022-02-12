<?php
namespace Pars\App\Admin\Overview;

use Pars\Core\View\ViewComponent;
use SplDoublyLinkedList;

/**
 * @method OverviewModel getModel()
 */
class OverviewComponent extends ViewComponent
{

    public function __construct()
    {
        $this->setTemplate(__DIR__ . '/templates/overview.php');
        $this->model = new OverviewModel();
    }
}