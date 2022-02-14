<?php
namespace Pars\Core\View;

class ViewEvent
{
    public const TARGET_SELF = 'self';
    public const TARGET_WINDOW = 'window';
    public const TARGET_ACTION = 'action';
    public const EVENT_CLICK = 'click';

    public string $event = self::EVENT_CLICK;
    public string $url = '';
    public string $handler = '';
    public string $target = self::TARGET_SELF;
    public string $title = '';

    public function __construct()
    {
        $this->url = url();
    }


}
