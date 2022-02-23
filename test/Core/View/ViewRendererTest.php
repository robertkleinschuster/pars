<?php
namespace ParsTest\Core\View;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewModel;
use Pars\Core\View\ViewRenderer;

class ViewRendererTest extends \PHPUnit\Framework\TestCase
{
    public function testRendering()
    {
        $component = new ViewComponent();

        $model = new ViewModel();
        $model->set('content', '1');
        $component->getModel()->push($model);

        $model = new ViewModel();
        $model->set('content', '2');
        $component->getModel()->push($model);

        $model = new ViewModel();
        $model->set('content', '3');
        $component->getModel()->push($model);


        $renderer = new ViewRenderer();
        $renderer->setComponent($component);
        $this->assertEquals("<div>
</div><div>
</div><div>
</div>", $renderer->render());
    }
}