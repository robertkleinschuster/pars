<?php

namespace Pars\Core\View\Browser;

use Pars\Core\View\Desktop\Desktop;
use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\Tree\DirectoryTreeModel;
use Pars\Core\View\Tree\Tree;
use Pars\Core\View\ViewComponent;

class Browser extends ViewComponent implements EntrypointInterface
{
    private Tree $tree;
    private Desktop $desktop;

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/browser.phtml');
        $model = new DirectoryTreeModel();
        $model->setDirectory('data/files');
        $this->getTree()->setItemModel($model);
        $this->push($this->getTree());
        $model = new DirectoryTreeModel();
        $model->setDirectory('data/files');
        $this->getDesktop()->setIconModel($model);
        $this->push($this->getDesktop());
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Browser.ts';
    }

    public function getTree(): Tree
    {
        if (!isset($this->tree)) {
            $this->tree = new Tree();
        }
        return $this->tree;
    }

    public function getDesktop(): Desktop
    {
        if (!isset($this->desktop)) {
            $this->desktop = new Desktop();
        }
        return $this->desktop;
    }
}
