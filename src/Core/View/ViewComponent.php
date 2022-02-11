<?php

namespace Pars\Core\View;

use SplDoublyLinkedList;

class ViewComponent
{
    protected ?string $template = 'templates/default.phtml';
    protected ViewModel $model;
    protected ?ViewEvent $event = null;
    protected SplDoublyLinkedList $children;

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
        $this->getChildren()->push($component);
        return $this;
    }

    /**
     * @return ViewEvent|null
     */
    public function getEvent(): ?ViewEvent
    {
        return $this->event;
    }

    /**
     * @param ViewEvent|null $event
     * @return ViewComponent
     */
    public function setEvent(?ViewEvent $event): ViewComponent
    {
        $this->event = $event;
        return $this;
    }

    public function withModel(ViewModel $model): static {
        $clone = clone $this;
        $clone->model = $model;
        if (isset($this->event)) {
            $clone->event = clone $this->event;
        }
        if (isset($this->children)) {
            $clone->children = clone $this->children;
        }
        return $clone;
    }

}