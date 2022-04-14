<?php

namespace Pars\Core\Util\Option;

use JsonSerializable;

class OptionHelper implements JsonSerializable
{
    public function has(string $option): bool
    {
        return isset($this->$option) && true === $this->$option;
    }

    public function enable(string $option): self
    {
        $this->$option = true;
        return $this;
    }

    public function disable(string $option): self
    {
        $this->$option = false;
        return $this;
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
