<?php

namespace Pars\Core\Http\Header\Accept;

use Pars\Core\Http\HttpException;

class Mime
{
    protected string $code;

    protected array $properties = [];

    /**
     * @param string $code
     * @throws HttpException
     */
    public function __construct(string $code)
    {
        $properties = explode(';', $code);
        if (!is_array($properties) || count($properties) == 0) {
            throw new HttpException('Invalid mime code.');
        }
        $this->code = array_shift($properties);
        foreach ($properties as $property) {
            $propertyData = explode('=', $property);
            if (count($propertyData) === 2) {
                $this->properties[$propertyData[0]] = $propertyData[1];
            }
        }
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getProperty(string $key)
    {
        return $this->properties[$key] ?? null;
    }

    public function getQuality()
    {
        return $this->getProperty('q');
    }
}
