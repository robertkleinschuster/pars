<?php

namespace Pars\Core\Log;

use Pars\Core\Util\Placeholder\PlaceholderHelper;
use Psr\Log\AbstractLogger;
use Stringable;
use Throwable;

class Log extends AbstractLogger
{
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $exception = null;
        if (isset($context['exception']) && $context['exception'] instanceof Throwable) {
            $exception = $context['exception'];
        }
        if ($message instanceof Throwable) {
            $exception = $message;
            $message = $message->getMessage();
        }

        $message = strtoupper($level) . ': ' . $message;

        if ($exception) {
            $context['message'] = $exception->getMessage();
            $context['trace'] = $exception->getTraceAsString();
            $context['code'] = $exception->getCode();
            $message = "$message ({code})\nTRACE:\n{trace}";
        }

        $message = PlaceholderHelper::replacePlaceholder($message, $context);
        error_log($message);
    }
}
