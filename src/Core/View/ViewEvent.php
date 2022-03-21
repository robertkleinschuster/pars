<?php

namespace Pars\Core\View;

use Pars\Core\Router\Route;

class ViewEvent
{
    public const TARGET_SELF = 'self';
    public const TARGET_WINDOW = 'window';
    public const TARGET_ACTION = 'action';
    public const TARGET_BLANK = 'blank';
    public const EVENT_CLICK = 'click';
    public const EVENT_CHANGE = 'change';

    public string $event = self::EVENT_CLICK;
    public string $target = self::TARGET_SELF;
    public string $url = '';
    public string $title = '';

    final public function __construct()
    {
        $this->url = url();
    }

    /**
     * @return array<string>
     */
    public function getUrlParams(): array
    {
        return Route::findKeys($this->url);
    }

    public function setUrlParam(string $key, string $value): self
    {
        $this->url = str_replace(":$key", $value, $this->url);
        return $this;
    }

    public function toAttributes(): string
    {
        $attributes = [];
        foreach ((array) $this as $key => $value) {
            if ($value) {
                $attributes[] = "data-$key='$value'";
            }
        }
        return implode(' ', $attributes);
    }

    public static function window(string $uri, string $title): static
    {
        /* @var $event ViewEvent */
        $event = create(static::class);
        $event->url = $uri;
        $event->target = self::TARGET_WINDOW;
        $event->title = $title;
        return $event;
    }

    public static function self(string $uri): static
    {
        /* @var $event ViewEvent */
        $event = create(static::class);
        $event->url = $uri;
        $event->target = self::TARGET_SELF;
        return $event;
    }

    public static function action(string $uri, string $title): static
    {
        /* @var $event ViewEvent */
        $event = create(static::class);
        $event->url = $uri;
        $event->target = self::TARGET_ACTION;
        $event->title = $title;
        return $event;
    }

    public static function blank(string $uri, string $title): static
    {
        /* @var $event ViewEvent */
        $event = create(static::class);
        $event->url = $uri;
        $event->target = self::TARGET_BLANK;
        $event->title = $title;
        return $event;
    }
}
