<?php

namespace Pars\Core\View\Layout;

use Pars\Core\View\{EntrypointInterface, ViewComponent, ViewRenderer};
use Psr\Http\Message\StreamInterface;

class Layout extends ViewComponent implements EntrypointInterface
{
    protected StreamInterface $header;
    protected StreamInterface $main;
    protected StreamInterface $footer;
    protected string $language = 'en';
    protected string $title = 'Default Title';
    protected string $css = '';
    protected string $js = '';

    public function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/layout.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Layout.ts';
    }

    /**
     * @param StreamInterface $header
     * @return Layout
     */
    public function setHeader(StreamInterface $header): Layout
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param StreamInterface $main
     * @return Layout
     */
    public function setMain(StreamInterface $main): Layout
    {
        $this->main = $main;
        return $this;
    }

    /**
     * @param StreamInterface $footer
     * @return Layout
     */
    public function setFooter(StreamInterface $footer): Layout
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @param string $language
     * @return Layout
     */
    public function setLanguage(string $language): Layout
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param string $title
     * @return Layout
     */
    public function setTitle(string $title): Layout
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function addTitle(string $title): Layout
    {
        if ($this->title) {
            $this->title = $title . ' - ' . $this->title;
        } else {
            $this->title = $title;
        }
        return $this;
    }

    public function unsetHeader(): self
    {
        unset($this->header);
        return $this;
    }

    public function unsetFooter(): self
    {
        unset($this->footer);
        return $this;
    }

    public function hide(array $hidden)
    {
        if (in_array('header', $hidden)) {
            $this->unsetHeader();
        }
        if (in_array('header', $hidden)) {
            $this->unsetFooter();
        }
    }

    public function onRender(ViewRenderer $renderer)
    {
        parent::onRender($renderer);
        $this->css = $renderer->getEntrypoints()->dumpCss();
        $this->js = $renderer->getEntrypoints()->dumpJs();
    }
}
