<?php

namespace Pars\Logic\Entity;

use DateTime;
use Exception;
use JsonSerializable;
use Pars\Core\Util\Json\JsonObject;
use Pars\Core\Util\Option\OptionsObject;
use Pars\Logic\Entity\Info\EntityInfo;

class Entity implements JsonSerializable
{
    public const TYPE_TYPE = 'type';
    public const TYPE_TEMPLATE = 'template';
    public const TYPE_STATE = 'state';
    public const TYPE_GROUP = 'group';
    public const TYPE_MENU = 'menu';
    public const TYPE_CONTEXT = 'context';
    public const TYPE_LANGUAGE = 'language';
    public const TYPE_COUNTRY = 'country';

    public const TYPE_TEXT = 'text';
    public const TYPE_ARTICLE = 'article';
    public const TYPE_SITE = 'site';

    public const STATE_ACTIVE = 'active';
    public const STATE_INACTIVE = 'inactive';

    public const LANGUAGE_DE = 'de';
    public const LANGUAGE_IT = 'it';
    public const LANGUAGE_FR = 'fr';
    public const LANGUAGE_EN = 'en';

    public const COUNTRY_AT = 'at';
    public const COUNTRY_DE = 'de';
    public const COUNTRY_CH = 'ch';

    public const DATA_INFO = 'info';

    protected string $Entity_ID = '';
    protected ?string $Entity_ID_Parent = null;
    protected ?string $Entity_ID_Template = null;
    protected ?string $Entity_ID_Original = null;

    protected string $Entity_Type = '';
    protected string $Entity_Context = '';
    protected string $Entity_Group = '';
    protected string $Entity_State = '';
    protected string $Entity_Language = '';
    protected string $Entity_Country = '';
    protected string $Entity_Code = '';
    protected int $Entity_Order = 0;
    protected string $Entity_Name = '';
    protected string $Entity_Data = '{}';
    protected string $Entity_Options = '{}';
    protected string $Entity_Created = '';
    protected string $Entity_Modified = '';

    private JsonObject $dataHelper;
    private OptionsObject $optionsHelper;

    private EntityInfo $info;

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
     * @return string|null
     */
    public function getParent(): ?string
    {
        return $this->Entity_ID_Parent;
    }

    /**
     * @param string|null $Entity_ID_Parent
     * @return Entity
     */
    public function setParent(?string $Entity_ID_Parent): Entity
    {
        $this->Entity_ID_Parent = $Entity_ID_Parent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->Entity_ID_Template;
    }

    /**
     * @param string|null $Entity_ID_Template
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
     * @param string|null $Entity_ID_Original
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
    public function getGroup(): string
    {
        return $this->Entity_Group;
    }

    /**
     * @param string $Entity_Group
     * @return Entity
     */
    public function setGroup(string $Entity_Group): Entity
    {
        $this->Entity_Group = $Entity_Group;
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
        return $this->getDataObject();
    }

    /**
     * @return string
     */
    public function getOptions(): string
    {
        return $this->getOptionsObject();
    }

    /**
     * @return JsonObject
     */
    public function getDataObject(): JsonObject
    {
        if (!isset($this->dataHelper)) {
            $this->dataHelper = new JsonObject($this->Entity_Data);
        }
        return $this->dataHelper;
    }

    /**
     * @return OptionsObject
     */
    public function getOptionsObject(): OptionsObject
    {
        if (!isset($this->optionsHelper)) {
            $this->optionsHelper = new OptionsObject($this->Entity_Options);
        }
        return $this->optionsHelper;
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

    public function getNameFallback(): string
    {
        if (empty($this->getName())) {
            return ucfirst($this->getCode());
        }
        return $this->getName();
    }

    public function find(string $name, $default = null)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->{$method}() ?? $default;
        }

        return $this->getOptionsObject()->find($name, null, 'options')
            ?? $this->getDataObject()->find($name, null, 'data')
            ?? $default;
    }

    final public function getInfo(): EntityInfo
    {
        $data = $this->getDataObject()[self::DATA_INFO] ?? new EntityInfo();

        if (is_array($data)) {
            $data = new EntityInfo($data);
        }
        $this->getDataObject()->offsetSet(self::DATA_INFO, $data);
        return $data;
    }

    public function clear(): self
    {
        $this->setParent('');
        $this->setTemplate('');
        $this->setOriginal('');
        $this->setType('');
        $this->setContext('');
        $this->setGroup('');
        $this->setState('');
        $this->setLanguage('');
        $this->setCountry('');
        $this->setCode('');
        $this->setName('');
        $this->setOrder(0);
        $this->getDataObject()->clear();
        $this->getOptionsObject()->clear();
        $this->Entity_Created = '';
        $this->Entity_Modified = '';
        return $this;
    }

    public function from(array $data): self
    {
        if (isset($data['parent'])) {
            $this->setParent($data['parent']);
            unset($data['parent']);
        }

        if (isset($data['template'])) {
            $this->setTemplate($data['template']);
            unset($data['template']);
        }

        if (isset($data['original'])) {
            $this->setOriginal($data['original']);
            unset($data['original']);
        }

        if (isset($data['type'])) {
            $this->setType($data['type']);
            unset($data['type']);
        }

        if (isset($data['state'])) {
            $this->setState($data['state']);
            unset($data['state']);
        }

        if (isset($data['context'])) {
            $this->setContext($data['context']);
            unset($data['context']);
        }

        if (isset($data['group'])) {
            $this->setGroup($data['group']);
            unset($data['group']);
        }

        if (isset($data['language'])) {
            $this->setLanguage($data['language']);
            unset($data['language']);
        }

        if (isset($data['country'])) {
            $this->setCountry($data['country']);
            unset($data['country']);
        }

        if (isset($data['code'])) {
            $this->setCode($data['code']);
            unset($data['code']);
        }

        if (isset($data['name'])) {
            $this->setName($data['name']);
            unset($data['name']);
        }

        if (isset($data['options'])) {
            $this->getOptionsObject()->from($data['options']);
            unset($data['options']);
        }

        if (isset($data['data'])) {
            $this->getDataObject()->from($data['data']);
            unset($data['data']);
        }

        if (!empty($data)) {
            $this->getDataObject()->fromArray($data);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        if ($this->getType()) {
            $data['type'] = $this->getType();
        }
        if ($this->getContext()) {
            $data['context'] = $this->getContext();
        }
        if ($this->getGroup()) {
            $data['group'] = $this->getGroup();
        }
        if ($this->getState()) {
            $data['state'] = $this->getState();
        }
        if ($this->getLanguage()) {
            $data['language'] = $this->getLanguage();
        }
        if ($this->getCountry()) {
            $data['country'] = $this->getCountry();
        }
        if ($this->getCode()) {
            $data['code'] = $this->getCode();
        }
        if ($this->getName()) {
            $data['name'] = $this->getName();
        }
        if (!$this->getDataObject()->isEmpty()) {
            $data['data'] = $this->getDataObject();
        }
        if (!$this->getOptionsObject()->isEmpty()) {
            $data['options'] = $this->getOptionsObject();
        }
        return $data;
    }
}
