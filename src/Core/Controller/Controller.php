<?php
namespace Pars\Core\Controller;

use Pars\Core\View\ViewComponent;
use Pars\Core\View\ViewRenderer;

class Controller
{
    protected ControllerRequest $request;
    protected ControllerResponse $response;
    protected ViewRenderer $renderer;

    /**
     * @param ControllerRequest $request
     * @param ControllerResponse $response
     * @param ViewRenderer $renderer
     */
    public function __construct(ControllerRequest $request, ControllerResponse $response, ViewRenderer $renderer)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }


    public function dispatch()
    {
        $component = new ViewComponent();
        $component->getModel()->setValue('mvc example');
        $this->renderer->setComponent($component);
    }

}