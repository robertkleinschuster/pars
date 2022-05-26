<?php

namespace Pars\Logic\Entity\Info;

use ArrayIterator;
use Generator;
use Pars\Core\Util\Json\JsonObject;
use Pars\Core\Util\Option\OptionsObject;
use Pars\Logic\Entity\Entity;
use Pars\Logic\Entity\EntityException;
use Pars\Logic\Entity\EntityRepository;

class EntityField extends JsonObject
{
    public const DATATYPE_STRING = 'string';
    public const VIEW_OPTION_OVERVIEW = 'overview';
    public const VIEW_OPTION_DETAIL = 'detail';

    public string $code = '';
    public string $name = '';
    public int $order = 0;
    public string $dataType = self::DATATYPE_STRING;
    public string $defaultValue = '';
    public ?string $chapter = null;
    public ?string $group = null;
    public ?string $icon = null;

    public ?Entity $reference = null;
    public array $options = [];

    public EntityFieldInput $input;

    public OptionsObject $viewOptions;

    public function __construct($array = [], int $flags = 0, string $iteratorClass = ArrayIterator::class)
    {
        if (isset($array['reference'])) {
            $array['reference'] = (new Entity())->from($array['reference']);
        }
        $array['order'] = (int)($array['order'] ?? 0);
        parent::__construct($array, $flags, $iteratorClass);
    }


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
     * @return EntityField
     */
    public function setCode(string $code): EntityField
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
     * @return EntityField
     */
    public function setName(string $name): EntityField
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
     * @return EntityField
     */
    public function setOrder(int $order): EntityField
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
     * @return EntityField
     */
    public function setChapter(?string $chapter): EntityField
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
     * @return EntityField
     */
    public function setGroup(?string $group): EntityField
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
     * @return EntityField
     */
    public function setDefaultValue(string $defaultValue): EntityField
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
     * @return EntityField
     */
    public function setDataType(string $dataType): EntityField
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return EntityField
     */
    public function setIcon(?string $icon): EntityField
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return EntityFieldInput
     */
    public function getInput(): EntityFieldInput
    {
        if (!isset($this->input)) {
            $this->input = $this['input'] = new EntityFieldInput($this['input'] ?? []);
        }
        return $this->input;
    }

    /**
     * @return Entity|null
     */
    public function getReference(): ?Entity
    {
        if (!isset($this->reference)) {
            $this->reference = $this['reference'] = new Entity();
        }
        return $this->reference;
    }

    /**
     * @return array
     * @throws EntityException
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
     * @return EntityField
     */
    public function setOptions(array $options): EntityField
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
     * @return OptionsObject
     */
    public function getViewOptions(): OptionsObject
    {
        if (!isset($this->viewOptions)) {
            $this->viewOptions = new OptionsObject($this['viewOptions'] ?? []);
        }
        return $this->viewOptions;
    }
}
