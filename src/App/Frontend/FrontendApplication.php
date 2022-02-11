<?php
namespace Pars\App\Frontend;

use Pars\App\Frontend\Favicon\FaviconMiddleware;
use Pars\Core\Application\Base\AbstractApplication;
use Pars\Core\Middleware\NotFoundMiddleware;
use Pars\Core\Stream\ClosureStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FrontendApplication extends AbstractApplication
{
    protected function init()
    {
        $this->container->register(NotFoundMiddleware::class, Error\NotFoundMiddleware::class);
        $this->pipeline->pipe('/favicon', $this->container->get(FaviconMiddleware::class));
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->pipeline->handle($request);
        $this->body = $response->getBody()->getContents();
        return $response->withBody(new ClosureStream($this->renderLayout(...)));
    }

    public function renderLayout()
    {
        require_once 'templates/layout.phtml';
    }

    public function __get(string $name)
    {
        return '';
    }
}