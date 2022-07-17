<?php

namespace Pars\App\Admin\Entity\Detail;

use Laminas\Diactoros\Response\HtmlResponse;
use Pars\App\Admin\Entity\Overview\EntityOverviewHandler;
use Pars\Core\Http\Stream\QueueStream;
use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EntityDetailHandler implements RequestHandlerInterface
{
    private ViewRenderer $renderer;
    private UriBuilder $uriBuilder;

    /**
     * @param ViewRenderer $renderer
     * @param UriBuilder $uriBuilder
     */
    public function __construct(ViewRenderer $renderer, UriBuilder $uriBuilder)
    {
        $this->renderer = $renderer;
        $this->uriBuilder = $uriBuilder;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queueStream = new QueueStream();

        $id = explode('/', $request->getAttribute('id'));
        $component = new EntityDetail();
        $component->setId(array_pop($id));
        $this->renderer->setComponent($component);
        $queueStream->push($this->renderer->render());

        if ($component->getModel()->getType()->isAllowChildren()) {
            $params = $request->getQueryParams();
            $params['mode'] = 'child';
            $params['type'] = $component->getModel()->getType()->getChildType();
            $overview = new EntityOverviewHandler($this->renderer, $this->uriBuilder);
            $queueStream->push($overview->handle($request->withQueryParams($params))->getBody());
        }

        return new HtmlResponse($queueStream);
    }
}
