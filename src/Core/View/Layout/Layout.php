<?php
namespace Pars\Core\View\Layout;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\ViewComponent;

class Layout extends ViewComponent implements EntrypointInterface
{

    protected string $main = '';
    protected string $header = '';
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
     * @return string
     */
    public function getMain(): string
    {
        return $this->main;
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
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
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
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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



}