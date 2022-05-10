<?php

namespace Pars\Core\Util\Option;

use JsonSerializable;

class OptionHelper implements JsonSerializable
{
    public function has(string $option): bool
    {
        return isset($this->$option) && true === $this->$option;
    }

    public function set(string $option, bool $value): self
    {
        $this->$option = $value;
        return $this;
    }

    public function enable(string $option): self
    {
        return $this->set($option, true);
    }

    public function disable(string $option): self
    {
        return $this->set($option, false);
    }

    public function all(bool $state = null): array
    {
        $options = [];
        //@phpstan-ignore-next-line
        foreach ($this as $option => $optionState) {
            if (null === $state || $optionState === $state) {
                $options[] = $option;
            }
        }
        return $options;
    }

    public function enabled(): array
    {
        return $this->all(true);
    }

    public function disabled(): array
    {
        return $this->all(false);
    }

    public function fromJson(string $json)
    {
        $data = json_decode($json, true);
        foreach ($data['enabled'] ?? [] as $option) {
            $this->enable($option);
        }

        foreach ($data['disabled'] ?? [] as $option) {
            $this->disable($option);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled(),
            'disabled' => $this->disabled()
        ];
    }
}
