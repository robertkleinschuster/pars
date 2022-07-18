<?php

namespace Pars\Core\View;

class ViewMessage
{
    public ?string $code = null;
    public ?string $id = null;
    public $data = null;
    public ?string $html = null;

    final public function __construct(?string $code, $data = null)
    {
        $this->code = $code;
        $this->data = $data;
    }

    public static function __set_state($data): ViewMessage
    {
        $message = new static(null);
        foreach ($data as $key => $value) {
            $message->$key = $value;
        }
        return $message;
    }
}
