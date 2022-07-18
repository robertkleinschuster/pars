<?php

namespace Pars\Core\View;

use Pars\Core\Application\Socket\WebSocket;

class ViewSocket
{
    private WebSocket $socket;

    /**
     * @param WebSocket $socket
     */
    public function __construct(WebSocket $socket)
    {
        $this->socket = $socket;
    }

    public function send(ViewMessage $message)
    {
        $this->socket->send(json_encode(['view' => $message]));
    }

    public function onMessage(callable $listener)
    {
        $this->socket->onMessage(function (string $data) use ($listener) {
            $data = json_decode($data);
            if (isset($data->view)) {
                $listener(ViewMessage::__set_state($data->view));
            }
        });
    }
}
