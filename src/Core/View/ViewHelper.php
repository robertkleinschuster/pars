<?php

namespace Pars\Core\View;

class ViewHelper implements EntrypointInterface
{
    public ViewComponent $component;
    public ViewSocket $socket;
    public array $events = [];
    private string $id;

    public static function getEntrypoint(): string
    {
        return __DIR__ . '/ViewHelper.ts';
    }

    /**
     * @param ViewComponent $component
     * @param ViewSocket $socket
     */
    public function __construct(ViewComponent $component, ViewSocket $socket)
    {
        $this->component = $component;
        $this->socket = $socket;
    }

    public function on(string $event, callable $listener)
    {
        $this->events[] = $event;
        $this->socket->onMessage(function (ViewMessage $message) use ($event, $listener) {
            if ($message->code === $event) {
                $listener($message);
            }
        });
    }

    public function dispatch(ViewMessage $message)
    {
        $this->socket->send($message);
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getId(): string
    {
        if (!isset($this->id)) {
            $this->id = uniqid();
        }
        return $this->id;
    }
}