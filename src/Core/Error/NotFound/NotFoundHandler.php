<?php

namespace Pars\Core\Error\NotFound;

use Pars\Core\Http\Header\Accept\AcceptHeader;
use Pars\Core\View\Layout\Layout;
use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundHandler implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;
    private StreamFactoryInterface $streamFactory;
    private ViewRenderer $renderer;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface $streamFactory
     * @param ViewRenderer $renderer
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        ViewRenderer $renderer
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->renderer = $renderer;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(404);
        $acceptHeader = $request->getAttribute(AcceptHeader::class);
        if ($acceptHeader instanceof AcceptHeader) {
            if ($acceptHeader->isHtml()) {
                $layout = $request->getAttribute(Layout::class);
                if ($layout instanceof Layout) {
                    $layout->setTitle(__('error.notfound.title'));
                }
                $notFound = new NotFound();
                $this->renderer->setComponent($notFound);
                $response = $response->withBody($this->renderer->render());
            } elseif ($acceptHeader->isJson()) {
                $body = $this->streamFactory->createStream(json_encode(['error' => 'not found']));
                $response = $response
                    ->withBody($body)
                    ->withAddedHeader('Content-Type', 'application/json');
            }
        }
        return $response;
    }
}
