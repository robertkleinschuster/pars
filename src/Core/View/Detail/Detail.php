<?php

namespace Pars\Core\View\Detail;

use Pars\Core\View\{EntrypointInterface, FormViewComponent, Input\Input, ViewComponent};

class Detail extends ViewComponent implements EntrypointInterface
{
    use GroupTrait;

    protected string $headingKey = 'heading';
    protected array $chapter = [];

    protected function init()
    {
        parent::init();
        $this->setTemplate(__DIR__ . '/Detail.phtml');
    }


    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Detail.ts';
    }

    /**
     * @return string
     */
    public function getHeadingKey(): string
    {
        return $this->headingKey;
    }

    /**
     * @param string $headingKey
     * @return Detail
     */
    public function setHeadingKey(string $headingKey): Detail
    {
        $this->headingKey = $headingKey;
        return $this;
    }

    public function push(ViewComponent $component, string $chapter = null, string $group = null): static
    {
        if ($component instanceof FormViewComponent) {
            $chapter = $chapter ?? $component->getChapter();
            $group = $group ?? $component->getGroup();
        }
        if (null !== $chapter) {
            $this->getChapter($chapter)->push($component, $group);
        } elseif (null !== $group) {
            $this->getGroup($group)->push($component);
        } else {
            parent::push($component);
        }
        return $this;
    }

    public function getChapter(string $name): DetailChapter
    {
        if (!isset($this->chapter[$name])) {
            $this->chapter[$name] = new DetailChapter();
            $this->chapter[$name]->setName($name);
            $this->push($this->chapter[$name]);
        }
        return $this->chapter[$name];
    }

    public function addInput(string $key, string $label, string $chapter = null, string $group = null): Input
    {
        $input = new Input();
        $input->key = $key;
        $input->label = $label;
        $this->push($input, $chapter, $group);
        return $input;
    }
}
