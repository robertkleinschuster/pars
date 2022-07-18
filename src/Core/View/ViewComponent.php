<?php

namespace Pars\Core\View;

use Pars\Core\Application\Socket\WebSocket;
use Pars\Core\Util\Option\OptionTrait;
use Psr\Http\Message\StreamInterface;
use SplDoublyLinkedList;

use function implode;

class ViewComponent
{
    use OptionTrait;

    protected ?string $template = __DIR__ . '/templates/default.phtml';
    protected ViewHelper $helper;
    protected ViewModel $model;
    protected ViewFormatter $formatter;
    protected ?ViewEvent $event = null;

    /**
     * @var iterable<ViewComponent>&SplDoublyLinkedList<ViewComponent>
     */
    protected SplDoublyLinkedList $children;
    protected ?self $parent = null;
    protected StreamInterface|string $content = '';

    protected string $tag = 'div';
    protected array $class = [];

    final public function __construct(WebSocket $socket)
    {
        $this->helper = new ViewHelper($this, new ViewSocket($socket));
        $this->init();
    }


    /**
     * @return ViewHelper
     */
    public function getHelper(): ViewHelper
    {
        return $this->helper;
    }

    protected function init()
    {
    }


    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getContent(): StreamInterface|string
    {
        return $this->content;
    }

    public function setContent(StreamInterface|string $content): ViewComponent
    {
        $this->content = $content;
        return $this;
    }


    public function isList(): bool
    {
        return $this->getModel()->isList();
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return ViewComponent
     */
    public function setTag(string $tag): ViewComponent
    {
        $this->tag = $tag;
        return $this;
    }

    public function getId(): string
    {
        return 'id-' . $this->getModel()->getId();
    }

    public function onRender(ViewRenderer $renderer)
    {
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

    /**
     * @return iterable<ViewComponent>&SplDoublyLinkedList<ViewComponent>
     */
    public function getChildren(): SplDoublyLinkedList
    {
        if (!isset($this->children)) {
            $this->children = new SplDoublyLinkedList();
        }
        return $this->children;
    }

    public function getFormatter(): ViewFormatter
    {
        if (!isset($this->formatter)) {
            $this->formatter = new ViewFormatter($this);
        }
        return $this->formatter;
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
        $clone->model = $model;
        return $clone;
    }

    public function __clone()
    {
        if (isset($this->model)) {
            $this->model = clone $this->model;
        }

        if (isset($this->event)) {
            $this->event = clone $this->event;
        }

        if (isset($this->children)) {
            $children = new SplDoublyLinkedList();
            foreach ($this->children as $child) {
                $child = clone $child;
                $child->parent = $this;
                $children->push($child);
            }
            $this->children = $children;
        }
    }

    public function clearChildren(): self
    {
        $this->children = new SplDoublyLinkedList();
        return $this;
    }

    protected function attr(): string
    {
        $attributes = [];
        $attributes[] = "data-id='{$this->getHelper()->getId()}'";
        foreach ($this->getHelper()->getEvents() as $event) {
            $attributes[] = "on$event='this.dispatch(arguments[0])'";
        }

        return implode(' ', $attributes);
    }

    public function getClass(): string
    {
        return implode(' ', $this->class);
    }

    public function addClass(string $class): self
    {
        $this->class[] = $class;
        return $this;
    }

    public function getValue(string $key)
    {
        return $this->getFormatter()->format($key, $this->getModel());
    }

    public function getParentValue(string $key)
    {
        return $this->getParent()->getValue($key);
    }

    public function setEventWindow(string $uri, string $title = ''): ViewEvent
    {
        $this->setEvent(ViewEvent::window($uri, $title));
        return $this->getEvent();
    }

    public function setEventLink(string $uri): ViewEvent
    {
        $this->setEvent(ViewEvent::self($uri));
        return $this->getEvent();
    }

    public function setEventAction(string $title = ''): ViewEvent
    {
        $this->setEvent(ViewEvent::action($title));
        return $this->getEvent();
    }
}
