<?php

namespace Pars\Core\View\Editor;

use Pars\Core\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FileEditorHandler implements RequestHandlerInterface
{
    private ViewRenderer $renderer;
    private StreamFactoryInterface $streamFactory;
    private ResponseFactoryInterface $responseFactory;

    /**
     * @param ViewRenderer $renderer
     * @param StreamFactoryInterface $streamFactory
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(
        ViewRenderer $renderer,
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->renderer = $renderer;
        $this->streamFactory = $streamFactory;
        $this->responseFactory = $responseFactory;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $file = $request->getAttribute('file');
        $editor = new Editor();
        if ($file) {
            $file = str_replace(['.', '~'], '', $file);
            if (is_file($file)) {
                if ($request->getMethod() === 'PUT') {
                    $content = $request->getBody()->getContents();
                    file_put_contents($file, $content);
                }
                $editor->setContent($this->streamFactory->createStreamFromFile($file));
            } elseif ($request->getMethod() === 'POST') {
                $dir = dirname($file);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                touch($file);
                $editor->setContent($this->streamFactory->createStreamFromFile($file));
            }
        }

        $this->renderer->setComponent($editor);
        return $this->responseFactory->createResponse()
            ->withBody($this->renderer->render());
    }
}
