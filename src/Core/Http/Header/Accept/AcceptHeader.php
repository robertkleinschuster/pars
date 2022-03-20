<?php

namespace Pars\Core\Http\Header\Accept;

use Pars\Core\Http\HttpException;
use Psr\Http\Message\RequestInterface;

class AcceptHeader
{
    private RequestInterface $request;

    private array $mimeList;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function isHtml(): bool
    {
        return $this->isMimeType('text/html');
    }


    public function isJson(): bool
    {
        return $this->isMimeType('application/json');
    }

    private function isMimeType(string $typeCode): bool
    {
        $result = false;
        try {
            $mimeList = $this->getMimeList();
            if (!empty($mimeList)) {
                $mime = reset($mimeList);
                $result = $mime->getCode() === $typeCode;
            }
        } catch (HttpException $exception) {
            error($exception);
        }
        return $result;
    }

    /**
     * @return Mime[]
     * @throws HttpException
     */
    public function getMimeList(): array
    {
        if (!isset($this->mimeList)) {
            $this->mimeList = $this->parseMime();
        }
        return $this->mimeList;
    }

    /**
     * @return Mime[]
     * @throws HttpException
     */
    private function parseMime(): array
    {
        $result = [];
        $headerLines = $this->request->getHeader('Accept');
        foreach ($headerLines as $headerLine) {
            $mimeTypes = explode(',', $headerLine);
            foreach ($mimeTypes as $mimeType) {
                $result[] = new Mime($mimeType);
            }
        }
        return $result;
    }
}
