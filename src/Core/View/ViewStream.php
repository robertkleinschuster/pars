<?php

namespace Pars\Core\View;

use Closure;
use Pars\Core\Http\Stream\ClosureStream;
use Throwable;

class ViewStream extends ClosureStream
{
    /**
     * @param ViewComponent $component
     */
    public function __construct(ViewComponent $component)
    {
        parent::__construct($this->buildClosure($component), $component);
    }

    private function buildClosure(ViewComponent $component): Closure
    {
        return Closure::fromCallable(function () use ($component) {
            try {
                include $component->getTemplate();
            } catch (Throwable $exception) {
                error($exception);
                if (ini_get('display_errors')) {
                    echo "<pre 
style='overflow: auto;margin: 1rem;padding: 1rem;background: #eeeeee;border: 1px solid #000;'>";
                    echo $exception;
                    echo "</pre>";
                }
            }
        });
    }
}
