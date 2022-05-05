<?php

namespace Pars\Core\View;

use Pars\Core\Http\Uri\UriBuilder;
use Pars\Core\Router\PatternRoute;

use function url;
use function str_replace;

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
    public UriBuilder|string $url = '';
    public string $title = '';
    public string $method;

    final public function __construct()
    {
        $this->url = url();
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     * @return ViewEvent
     */
    public function setEvent(string $event): ViewEvent
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return ViewEvent
     */
    public function setTarget(string $target): ViewEvent
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return UriBuilder|string
     */
    public function getUrl(): UriBuilder|string
    {
        return $this->url;
    }

    /**
     * @param UriBuilder|string $url
     * @return ViewEvent
     */
    public function setUrl(UriBuilder|string $url): ViewEvent
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ViewEvent
     */
    public function setTitle(string $title): ViewEvent
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return ViewEvent
     */
    public function setMethod(string $method): ViewEvent
    {
        $this->method = $method;
        return $this;
    }

    public function setParam(string $name, string $value)
    {
        $this->{"param-$name"} = $value;
        return $this;
    }

    /**
     * @return array<string>
     */
    public function getRouteParams(): array
    {
        return PatternRoute::findKeys($this->url);
    }

    public function setRouteParam(string $key, string $value): self
    {
        $this->url = str_replace(":$key", $value, $this->url);
        return $this;
    }

    public function toAttributes(ViewComponent $component): string
    {
        $attributes = "data-event='{$this->event}'";
        $attributes .= " data-target='{$this->target}'";
        if (!empty($this->url)) {
            $attributes .= " data-url='{$this->url}'";
        }
        if (!empty($this->title)) {
            $attributes .= " data-title='{$this->title}'";
        }
        if (!empty($this->method)) {
            $attributes .= " data-method='{$this->method}'";
        }
        $attributes .= " tabindex='0'";
        return $attributes;
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

    public static function action(string $title = ''): static
    {
        /* @var $event ViewEvent */
        $event = create(static::class);
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
