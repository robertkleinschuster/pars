<?php

namespace Pars\Core\Http\Emitter;

use Pars\Core\View\Entrypoints;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class SapiEmitter
{
    public function emit(ResponseInterface $response): void
    {
        $this->assertNoPreviousOutput();
        $this->injectContentLength($response);
        $this->emitHeaders($response);
        $this->emitStatusLine($response);
        $this->emitBody($response);
        $this->closeConnection();
    }

    protected function assertNoPreviousOutput(): void
    {
        $file = $line = null;

        if (headers_sent($file, $line)) {
            throw new RuntimeException(sprintf(
                'Unable to emit response: Headers already sent in file %s on line %s. '
                . 'This happens if 
                echo, print, printf, print_r, var_dump, var_export 
                or similar statement that writes to the output buffer are used.',
                $file,
                (string)$line
            ));
        }
    }

    public function injectContentLength(ResponseInterface $response): ResponseInterface
    {
        if ($response->hasHeader('Content-Length')) {
            return $response;
        }

        $responseBody = $response->getBody();

        if ($responseBody->getSize() !== null) {
            /** @var ResponseInterface $response */
            $response = $response->withHeader('Content-Length', (string)$responseBody->getSize());
        }

        return $response;
    }

    protected function emitHeaders(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();
        if (isset($_SERVER['HTTP_INJECT']) && $_SERVER['HTTP_INJECT'] === 'true') {
            $response = Entrypoints::injectHeaders($response);
        }
        foreach ($response->getHeaders() as $header => $values) {
            $name = $this->toWordCase($header);
            $first = $name !== 'Set-Cookie';

            foreach ($values as $value) {
                header(
                    sprintf(
                        '%s: %s',
                        $name,
                        $value
                    ),
                    $first,
                    $statusCode
                );

                $first = false;
            }
        }
    }

    protected function toWordCase(string $header): string
    {
        $filtered = str_replace('-', ' ', $header);
        $filtered = ucwords($filtered);

        return str_replace(' ', '-', $filtered);
    }

    protected function emitStatusLine(ResponseInterface $response): void
    {
        $statusCode = $response->getStatusCode();

        header(
            vsprintf(
                'HTTP/%s %d%s',
                [
                    $response->getProtocolVersion(),
                    $statusCode,
                    rtrim(' ' . $response->getReasonPhrase()),
                ]
            ),
            true,
            $statusCode
        );
    }

    private function emitBody(ResponseInterface $response): void
    {
        echo $response->getBody();
    }

    protected function closeConnection(): void
    {
        if (!in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
            $this->closeOutputBuffers(0, true);
        }

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    public function closeOutputBuffers(int $maxBufferLevel, bool $flush): void
    {
        $status = ob_get_status(true);
        $level = count($status);
        $flags = PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE);

        while (
            $level-- > $maxBufferLevel
            && isset($status[$level])
            && ($status[$level]['del'] ?? !isset($status[$level]['flags'])
                || $flags === ($status[$level]['flags'] & $flags))
        ) {
            if ($flush) {
                ob_end_flush();
            } else {
                ob_end_clean();
            }
        }
    }
}
