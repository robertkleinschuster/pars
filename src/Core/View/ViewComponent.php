<?php

namespace Pars\Core\View;

use Pars\Core\Router\Route;
use SplDoublyLinkedList;

class ViewComponent
{
    protected ?string $template = 'templates/default.phtml';
    protected ViewModel $model;
    protected ?ViewEvent $event = null;
    protected SplDoublyLinkedList $children;
    protected ?self $parent = null;
    protected string $content = '';
    protected string $tag = 'div';

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): ViewComponent
    {
        $this->content = $content;
        return $this;
    }

    public function isFirstChild(): bool
    {
        return $this->parent->getChildren()->bottom() === $this;
    }

    public function isLastChild(): bool
    {
        return $this->parent->getChildren()->top() === $this;
    }

    public function getModel(): ViewModel
    {
        if (!isset($this->model)) {
            $this->model = new ViewModel();
        }
        return $this->model;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): ViewComponent
    {
        $this->template = $template;
        return $this;
    }

    public function getChildren(): SplDoublyLinkedList
    {
        if (!isset($this->children)) {
            $this->children = new SplDoublyLinkedList();
        }
        return $this->children;
    }

    public function push(ViewComponent $component): static
    {
        $component->parent = $this;
        $this->getChildren()->push($component);
        return $this;
    }

    public function getEvent(): ?ViewEvent
    {
        return $this->event;
    }

    public function setEvent(?ViewEvent $event): ViewComponent
    {
        $this->event = $event;
        return $this;
    }

    public function withModel(ViewModel $model): static
    {
        $clone = clone $this;
        $clone->parent = $this;
        $clone->model = $model;
        if (isset($this->event)) {
            $clone->event = clone $this->event;
        }
        if (isset($this->children)) {
            $clone->children = clone $this->children;
        }
        $clone->updateParents();
        return $clone;
    }

    private function updateParents()
    {
        if (isset($this->children)) {
            foreach ($this->children as $child) {
                $child->parent = $this;
                $child->updateParents();
            }
        }
    }

    protected function attr(): string
    {
        $result = [];
        if ($this->getEvent()) {
            foreach ($this->getEvent() as $key => $value) {
                if ($value) {
                    if ($key == 'url') {
                        foreach (Route::findKeys($value) as $k) {
                            $value = str_replace(":$k", $this->getValue($k), $value);
                        }
                    }
                    $result[] = "data-$key='$value'";
                }
            }
        }
        return implode(' ', $result);
    }

    public function getValue(string $key)
    {
        return $this->getModel()->get($key);
    }

    public function __get(string $name)
    {
        if ($name === 'attr') {
            return $this->attr();
        }
        return null;
    }


}