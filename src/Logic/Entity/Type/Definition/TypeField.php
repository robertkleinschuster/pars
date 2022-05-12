<?php

namespace Pars\Logic\Entity\Type\Definition;

use Generator;
use JsonSerializable;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\EntityRepository;

class TypeField implements JsonSerializable
{
    public const DATATYPE_STRING = 'string';

    private string $code = '';
    private string $name = '';
    private int $order = 0;
    private string $dataType = self::DATATYPE_STRING;
    private string $defaultValue = '';
    private ?string $chapter = null;
    private ?string $group = null;

    private ?Entity $reference = null;
    private array $options = [];

    private TypeInput $input;


    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function getNormalizedCode(): string
    {
        return self::normalizeCode($this->getCode());
    }

    public static function normalizeCode(string $code): string
    {
        return str_replace(['[', ']'], '_', $code);
    }

    /**
     * @param string $code
     * @return TypeField
     */
    public function setCode(string $code): TypeField
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (empty($this->name)) {
            $this->name = ucfirst($this->code);
        }
        return $this->name;
    }

    /**
     * @param string $name
     * @return TypeField
     */
    public function setName(string $name): TypeField
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return TypeField
     */
    public function setOrder(int $order): TypeField
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChapter(): ?string
    {
        return $this->chapter;
    }

    /**
     * @param string|null $chapter
     * @return TypeField
     */
    public function setChapter(?string $chapter): TypeField
    {
        $this->chapter = $chapter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param string|null $group
     * @return TypeField
     */
    public function setGroup(?string $group): TypeField
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    /**
     * @param string $defaultValue
     * @return TypeField
     */
    public function setDefaultValue(string $defaultValue): TypeField
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     * @return TypeField
     */
    public function setDataType(string $dataType): TypeField
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return TypeInput
     */
    public function getInput(): TypeInput
    {
        if (!isset($this->input)) {
            $this->input = new TypeInput($this);
        }
        return $this->input;
    }

    /**
     * @param TypeInput $input
     * @return TypeField
     */
    public function setInput(TypeInput $input): TypeField
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @return Entity|null
     */
    public function getReference(): ?Entity
    {
        if (!isset($this->reference)) {
            $this->reference = new Entity();
        }
        return $this->reference;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        if (empty($this->options)) {
            foreach ($this->findReference() as $item) {
                $this->options[$item->getCode()] = $item->getNameFallback();
            }
        }
        return $this->options;
    }

    /**
     * @param array $options
     * @return TypeField
     */
    public function setOptions(array $options): TypeField
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return Generator&Entity[]
     * @throws EntityException
     */
    public function findReference(): Generator
    {
        return (new EntityRepository())->find($this->getReference());
    }

    /**
     * @param Entity|null $reference
     * @return TypeField
     */
    public function setReference(?Entity $reference): TypeField
    {
        $this->reference = $reference;
        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        if ($this->getCode()) {
            $data['code'] = $this->getCode();
        }
        if ($this->getName()) {
            $data['name'] = $this->getName();
        }
        if ($this->getOrder()) {
            $data['order'] = $this->getOrder();
        }
        if ($this->getDataType()) {
            $data['dataType'] = $this->getDataType();
        }
        if ($this->getDefaultValue()) {
            $data['defaultValue'] = $this->getDefaultValue();
        }
        if (null !== $this->getChapter()) {
            $data['chapter'] = $this->getChapter();
        }
        if (null !== $this->getGroup()) {
            $data['group'] = $this->getGroup();
        }
        if (isset($this->input)) {
            $data['input'] = $this->getInput();
        }
        if (isset($this->reference)) {
            $data['reference'] = $this->getReference();
        }
        return $data;
    }

    public function from(array $data): self
    {
        $this->setCode($data['code'] ?? $this->getCode());
        $this->setName($data['name'] ?? $this->getName());
        $this->setOrder((int)($data['order'] ?? $this->getOrder()));
        $this->setDataType($data['dataType'] ?? $this->getDataType());
        $this->setDefaultValue($data['defaultValue'] ?? $this->getDefaultValue());
        $this->setChapter($data['chapter'] ?? $this->getChapter());
        $this->setGroup($data['group'] ?? $this->getGroup());
        $this->getInput()->from($data['input'] ?? []);
        if (isset($data['reference'])) {
            $this->getReference()->from($data['reference']);
        }
        return $this;
    }
}
