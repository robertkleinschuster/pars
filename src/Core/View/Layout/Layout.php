<?php

namespace Pars\Core\View\Layout;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Layout extends ViewComponent implements EntrypointInterface
{

    protected string $header;
    protected string $main;
    protected string $footer;
    protected string $language = '';
    protected string $title = '';

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/layout.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Layout.ts';
    }

    /**
     * @param string $header
     * @return Layout
     */
    public function setHeader(string $header): Layout
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $main
     * @return Layout
     */
    public function setMain(string $main): Layout
    {
        $this->main = $main;
        return $this;
    }

    /**
     * @param string $footer
     * @return Layout
     */
    public function setFooter(string $footer): Layout
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
            $this->title .= ' - ' . $title;
        } else {
            $this->title = $title;
        }
        return $this;
    }


}