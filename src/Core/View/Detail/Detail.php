<?php

namespace Pars\Core\View\Detail;

use Pars\Core\View\Input\Input;
use Pars\Core\View\ViewComponent;

class Detail extends ViewComponent
{
    use GroupTrait;

    protected array $chapter = [];

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate(__DIR__ . '/templates/detail.phtml');
    }

    public function push(ViewComponent $component, string $chapter = null, string $group = null): static
    {
        $component->main = $this->main;
        if ($chapter) {
            $this->getChapter($chapter)->push($component, $group);
        } elseif ($group) {
            $this->getGroup($group)->push($component);
        } else {
            parent::push($component);
        }
        return $this;
    }

    public function getChapter(string $name): DetailChapter
    {
        if (!isset($this->chapter[$name])) {
            $this->chapter[$name] = create(DetailChapter::class);
            $this->chapter[$name]->setName($name);
            $this->push($this->chapter[$name]);
        }
        return $this->chapter[$name];
    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null)
    {
        /* @var Input $input */
        $input = create(Input::class);
        $input->key = $key;
        $input->label = $label;
        $this->push($input, $chapter, $group);
        return $input;
    }
}
