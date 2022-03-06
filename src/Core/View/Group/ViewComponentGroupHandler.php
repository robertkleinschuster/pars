<?php
namespace Pars\Core\View\Group;

use Pars\Core\Http\HtmlResponse;
use Pars\Core\Http\NotFoundResponse;
use Pars\Core\View\ViewPrefix;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplStack;

class ViewComponentGroupHandler implements RequestHandlerInterface
{
    protected const PREFIX = 'group';
    protected SplStack $handlers;
    protected static int $componentGroupId = 0;
    public function __construct()
    {
        self::$componentGroupId++;
        $this->handlers = new SplStack();

    }

    public function push(RequestHandlerInterface $handler): static
    {
        $this->handlers->unshift($handler);
        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $prefix = new ViewPrefix();
        if ($request->getHeaderLine('handler') && str_starts_with($request->getHeaderLine('handler'), self::PREFIX)) {
            foreach ($this->handlers as $key => $handler) {
                /* @var RequestHandlerInterface $handler */
                if ($request->getHeaderLine('handler') == $this->buildHandlerId($key)) {
                    return $handler->handle($request);
                }
            }
            return create(NotFoundResponse::class);
        } else {
            $body = '';
            foreach ($this->handlers as $key => $handler) {
                $handlerId = $this->buildHandlerId($key);
                /* @var RequestHandlerInterface $handler */
                $html = $handler->handle($request)->getBody()->getContents();
                $html = $prefix->addData($html, ['handler' => $handlerId]);
                $body .= $html;
            }
            $group = new ViewComponentGroup();
            $group->setContent($body);
            return create(HtmlResponse::class, render($group));
        }
    }

    protected function buildHandlerId(int $index): string
    {
        return implode('_', [self::PREFIX, self::$componentGroupId, $index]);
    }
}