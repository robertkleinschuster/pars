<?php

namespace Pars\App\Admin;

use Pars\App\Admin\Mvc\MvcHandler;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Application\Base\PathApplicationInterface;
use Pars\Core\Middleware\ClearcacheMiddleware;
use Pars\Core\Middleware\PhpinfoMiddleware;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminApplication extends AbstractApplication implements PathApplicationInterface
{
    protected string $body;
    protected string $language;
    protected string $title;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->pipeline->handle($request);
        $this->body = $response->getBody()->getContents();
        $this->language = 'de';
        $this->title = 'title';
        return $response->withBody(new ClosureStream($this->renderLayout(...)));
    }

    public function renderLayout()
    {
        include 'templates/layout.phtml';
    }

    public function __get(string $name)
    {
        return '';
    }

    public function getPath(): string
    {
        return '/admin';
    }

    protected function init()
    {
        $this->pipeline->pipe('/phpinfo', $this->container->get(PhpinfoMiddleware::class));
        $this->pipeline->pipe('/clearcache', $this->container->get(ClearcacheMiddleware::class));
        $this->router->route('/', $this->container->get(MvcHandler::class));
    }


}