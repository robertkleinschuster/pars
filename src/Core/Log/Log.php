<?php

namespace Pars\Core\Log;

use Exception;
use Pars\Core\Placeholder\PlaceholderHelper;
use Psr\Log\AbstractLogger;
use Stringable;

class Log extends AbstractLogger
{
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $exception = null;
        if (isset($context['exception']) && $context['exception'] instanceof Exception) {
            $exception = $context['exception'];
        }
        if ($message instanceof Exception) {
            $exception = $message;
            $message = $message->getMessage();
        }

        $message = strtoupper($level) . ': ' . $message;

        if ($exception) {
            $context['message'] = $exception->getMessage();
            $context['trace'] = $exception->getTraceAsString();
            $context['code'] = $exception->getCode();
            $message = "$message ({code}: {message})\nTRACE:\n{trace}";
        }

        $message = PlaceholderHelper::replacePlaceholder($message, $context);
        error_log($message);
    }
}
