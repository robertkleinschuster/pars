<?php

namespace Pars\Core\Util\Json;

use ArrayIterator;
use ArrayObject;
use JsonSerializable;

class JsonObject extends ArrayObject implements JsonSerializable
{
    public function __construct(
        $array = [],
        int $flags = 0,
        string $iteratorClass = ArrayIterator::class
    ) {
        if (is_string($array)) {
            $array = json_decode($array, true);
        }

        parent::__construct($array, $flags, $iteratorClass);

        foreach (get_object_vars($this) as $key => $value) {
            if (isset($this[$key])) {
                $this->{$key} = &$this[$key];
            } elseif (isset($this->{$key})) {
                $this[$key] = $this->{$key};
                $this->{$key} = &$this[$key];
            }
        }
    }


    public function find(string $key, $default = null, string $prefix = null)
    {
        // remove prefix if given
        if (null !== $prefix && strpos($key, $prefix) === 0) {
            $key = preg_replace(["/$prefix\[/", '/]/'], '', $key, 1);
        }

        // immediately return if root key
        if (strpos($key, '[') === false && strpos($key, '.') === false) {
            return $this[$key] ?? $default;
        }

        // determine flat array key separator. e.g.: foo.bar or foo[bar]
        $mode = '';
        if (strpos($key, '[') !== false) {
            $mode = 'form';
        }

        return $this->flatten($this->getArrayCopy(), $mode)[$key] ?? $default;
    }

    public function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        if (is_array($data)) {
            $this->fromArray($data);
        }
        return $this;
    }

    public function from($data): self
    {
        if (is_array($data)) {
            $this->fromArray($data);
        } elseif (is_string($data)) {
            $this->fromJson($data);
        }
        return $this;
    }

    public function fromArray(array $data): self
    {
        $this->exchangeArray(array_replace_recursive($this->getArrayCopy(), $data));
        return $this;
    }

    public function clear(): self
    {
        $this->exchangeArray([]);
        return $this;
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize());
    }

    private function flatten(array $array, string $mode = '', string $prefix = '', string $suffix = ''): array
    {
        $initialPrefix = '.';
        $initialSuffix = '';

        if ($mode == 'form') {
            $initialPrefix = '[';
            $initialSuffix = ']';
        }

        $result = [];

        foreach ($array as $key => $value) {
            if ($value instanceof ArrayObject) {
                $value = $value->getArrayCopy();
            } elseif ($value instanceof JsonSerializable) {
                $value = $value->jsonSerialize();
            }
            if (is_array($value)) {
                $result = array_merge(
                    $result,
                    $this->flatten($value, $mode, $prefix . $key . $suffix . $initialPrefix, $initialSuffix)
                );
            } else {
                $result[$prefix . $key . $suffix] = $value;
            }
        }

        return $result;
    }
}
