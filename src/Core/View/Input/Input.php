<?php

namespace Pars\Core\View\Input;

use Pars\Core\View\EntrypointInterface;
use Pars\Core\View\FormViewComponent;
use Pars\Core\View\Input\Type\Checkbox;
use Pars\Core\View\Input\Type\InputType;
use Pars\Core\View\Input\Type\Number;
use Pars\Core\View\Input\Type\Text;
use Pars\Core\View\ViewException;

class Input extends FormViewComponent implements EntrypointInterface
{
    public InputType $type;
    public bool $disabled = false;

    private static array $types = [
        'text' => Text::class,
        'checkbox' => Checkbox::class,
        'number' => Number::class
    ];

    /**
     * @throws ViewException
     */
    public function init()
    {
        parent::init();
        $this->setType('text');
        $this->setTemplate(__DIR__ . '/templates/input.phtml');
    }

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/Input.ts';
    }

    protected function attr(): string
    {
        $result = parent::attr();
        $attributes[] = "type='$this->type'";
        $attributes[] = "name='$this->key'";
        if ($this->isDisabled()) {
            $attributes[] = "disabled";
        }
        $attributes = $this->type->attributes($this, $attributes);
        return $result . ' ' . implode(' ', $attributes);
    }

    /**
     * @param string|InputType $type
     * @return Input
     * @throws ViewException
     */
    public function setType($type): Input
    {
        if (is_string($type)) {
            if (!isset(self::$types[$type])) {
                throw new ViewException("Invalid input type: $type");
            }
            $type = new (self::$types[$type])();
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return Input
     */
    public function setDisabled(bool $disabled): Input
    {
        $this->disabled = $disabled;
        return $this;
    }
}
