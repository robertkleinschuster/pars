<?php

namespace Pars\Logic\Entity;

use DateTime;
use Exception;

class Entity
{
    public const TYPE_DEFAULT = 'default';
    public const TYPE_TYPE = 'type';
    public const TYPE_STATE = 'state';
    public const TYPE_CONTEXT = 'context';
    public const TYPE_LANGUAGE = 'language';
    public const TYPE_COUNTRY = 'country';

    public const STATE_ACTIVE = 'active';
    public const STATE_INACTIVE = 'inactive';

    public const CONTEXT_DEFINITION = 'definition';
    public const CONTEXT_DATA = 'data';

    public const LANGUAGE_DE = 'de';
    public const LANGUAGE_IT = 'it';
    public const LANGUAGE_FR = 'fr';
    public const LANGUAGE_EN = 'en';

    public const COUNTRY_AT = 'at';
    public const COUNTRY_DE = 'de';
    public const COUNTRY_CH = 'ch';

    private string $Entity_ID = '';
    private ?string $Entity_ID_Parent = null;
    private ?string $Entity_ID_Template = null;
    private ?string $Entity_ID_Original = null;

    private string $Entity_Type = self::TYPE_DEFAULT;
    private string $Entity_State = self::STATE_ACTIVE;
    private string $Entity_Context = self::CONTEXT_DATA;
    private string $Entity_Language = self::LANGUAGE_DE;
    private string $Entity_Country = self::COUNTRY_AT;
    private string $Entity_Code = '';
    private int $Entity_Order = 0;
    private string $Entity_Name = '';
    private string $Entity_Data = '{}';
    private string $Entity_Created = '';
    private string $Entity_Modified = '';

    final public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->Entity_ID;
    }

    /**
     * @param string $Entity_ID
     * @return Entity
     */
    public function setId(string $Entity_ID): Entity
    {
        $this->Entity_ID = $Entity_ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getParent(): ?string
    {
        return $this->Entity_ID_Parent;
    }

    /**
     * @param string $Entity_ID_Parent
     * @return Entity
     */
    public function setParent(?string $Entity_ID_Parent): Entity
    {
        $this->Entity_ID_Parent = $Entity_ID_Parent;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): ?string
    {
        return $this->Entity_ID_Template;
    }

    /**
     * @param string $Entity_ID_Template
     * @return Entity
     */
    public function setTemplate(?string $Entity_ID_Template): Entity
    {
        $this->Entity_ID_Template = $Entity_ID_Template;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginal(): ?string
    {
        return $this->Entity_ID_Original;
    }

    /**
     * @param string $Entity_ID_Original
     * @return Entity
     */
    public function setOriginal(?string $Entity_ID_Original): Entity
    {
        $this->Entity_ID_Original = $Entity_ID_Original;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->Entity_State;
    }

    /**
     * @param string $Entity_State
     * @return Entity
     */
    public function setState(string $Entity_State): Entity
    {
        $this->Entity_State = $Entity_State;
        return $this;
    }

    /**
     * @return string
     */
    public function getContext(): string
    {
        return $this->Entity_Context;
    }

    /**
     * @param string $Entity_Context
     * @return Entity
     */
    public function setContext(string $Entity_Context): Entity
    {
        $this->Entity_Context = $Entity_Context;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->Entity_Language;
    }

    /**
     * @param string $Entity_Language
     * @return Entity
     */
    public function setLanguage(string $Entity_Language): Entity
    {
        $this->Entity_Language = $Entity_Language;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->Entity_Country;
    }

    /**
     * @param string $Entity_Country
     * @return Entity
     */
    public function setCountry(string $Entity_Country): Entity
    {
        $this->Entity_Country = $Entity_Country;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Entity_Name;
    }

    /**
     * @param string $name
     * @return Entity
     */
    public function setName(string $name): Entity
    {
        $this->Entity_Name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->Entity_Code;
    }

    /**
     * @param string $code
     * @return Entity
     */
    public function setCode(string $code): Entity
    {
        $this->Entity_Code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->Entity_Type;
    }

    /**
     * @param string $type
     * @return Entity
     */
    public function setType(string $type): Entity
    {
        $this->Entity_Type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->Entity_Order;
    }

    /**
     * @param int $order
     * @return Entity
     */
    public function setOrder(int $order): Entity
    {
        $this->Entity_Order = $order;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->Entity_Data;
    }

    /**
     * @param string $data
     * @return Entity
     */
    public function setData(string $data): Entity
    {
        $this->Entity_Data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataArray(): array
    {
        return json_decode($this->Entity_Data, true);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setDataArray(array $data): Entity
    {
        $this->Entity_Data = json_encode($data);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getCreated(): DateTime
    {
        return new DateTime($this->Entity_Created);
    }

    /**
     * @throws Exception
     */
    public function getModified(): DateTime
    {
        return new DateTime($this->Entity_Modified);
    }

    public function clear(): self
    {
        $this->setType('');
        $this->setState('');
        $this->setContext('');
        $this->setLanguage('');
        $this->setCountry('');
        $this->setCode('');
        $this->setDataArray([]);
        $this->setParent('');
        $this->setTemplate('');
        $this->setOriginal('');
        return $this;
    }

    public function from(array $data): self
    {
        if (isset($data['parent'])) {
            $this->setParent($data['parent']);
        }

        if (isset($data['type'])) {
            $this->setType($data['type']);
        }

        if (isset($data['state'])) {
            $this->setState($data['state']);
        }

        if (isset($data['context'])) {
            $this->setContext($data['context']);
        }

        if (isset($data['language'])) {
            $this->setLanguage($data['language']);
        }

        if (isset($data['country'])) {
            $this->setCountry($data['country']);
        }

        if (isset($data['code'])) {
            $this->setCode($data['code']);
        }

        if (isset($data['name'])) {
            $this->setName($data['name']);
        }
        return $this;
    }
}
