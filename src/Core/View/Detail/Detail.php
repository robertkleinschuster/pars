<?php

namespace Pars\Core\View\Detail;

use Pars\Core\View\{EntrypointInterface, Input\Input, ViewComponent};

class Detail extends ViewComponent implements EntrypointInterface
{
    use GroupTrait;

    protected array $chapter = [];

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/templates/detail.phtml');
    }


    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Detail.ts';
    }

    public function push(ViewComponent $component, string $chapter = null, string $group = null): static
    {
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
