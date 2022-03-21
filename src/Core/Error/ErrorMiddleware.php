<?php

namespace Pars\Core\Error;

use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

use function response;

class ErrorMiddleware implements MiddlewareInterface
{
    private ViewRenderer $renderer;


    protected string $error = '';

    /**
     * @param ViewRenderer $renderer
     */
    public function __construct(ViewRenderer $renderer)
    {
        $this->renderer = $renderer;
        set_error_handler($this);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $hasLayout = $request->getAttribute(Layout::class);
            error($exception);
            $error = new Error();
            $error->getModel()->set('exception', $exception);
            $error->getModel()->set('code', $exception->getCode());
            $error->getModel()->set('message', $exception->getMessage());
            $error->getModel()->set('trace', $exception->getTraceAsString());
            $this->renderer->setComponent($error);

            if (!$hasLayout) {
                $layout = new Layout();
                $layout->setMain($this->renderer->render());
                $this->renderer->setComponent($layout);
            }

            if (headers_sent()) {
                echo $this->renderer->render();
                exit;
            } else {
                return response($this->renderer->render(), 500);
            }
        }
        return $response;
    }

    public function __invoke($errno, $errstr, $errfile, $errline)
    {
        $message = "$errno: $errstr ($errfile:$errline)";
        error($message);
        $error = new Error();
        $error->getModel()->set('message', $message);
        $this->renderer->setComponent($error);
        $layout = new Layout();
        $layout->setMain($this->renderer->render());
        $this->renderer->setComponent($layout);
        echo $this->renderer->render();
        exit;
    }
}
