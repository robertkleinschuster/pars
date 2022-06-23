<?php

namespace Pars\Core\View;

use Pars\Core\View\Input\Input;

class FormViewComponent extends ViewComponent
{
    public string $key = '';
    public ?string $id = null;
    public string $label = '';
    public ?string $chapter = null;
    public ?string $group = null;

    /**
     * @param string $key
     * @return Input
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $label
     * @return Input
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFullwidth(bool $state): self
    {
        if ($state) {
            $this->class['fullwidth'] = 'fullwidth';
        } else {
            unset($this->class['fullwidth']);
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChapter(): ?string
    {
        return $this->chapter;
    }

    /**
     * @param string|null $chapter
     * @return FormViewComponent
     */
    public function setChapter(?string $chapter): FormViewComponent
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param string|null $group
     * @return FormViewComponent
     */
    public function setGroup(?string $group): FormViewComponent
    {
        $this->group = $group;
        return $this;
    }
}
