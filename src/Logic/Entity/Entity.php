<?php

namespace Pars\Logic\Entity;

use DateTime;

class Entity
{
    private string $Entity_ID = '';
    private ?string $Entity_ID_Parent = null;
    private ?string $Entity_ID_Template = null;
    private ?string $Entity_ID_Original = null;

    private string $Entity_Type = '';
    private string $Entity_State = '';
    private string $Entity_Context = '';
    private string $Entity_Language = '';
    private string $Entity_Country = '';
    private string $Entity_Code = '';
    private int $Entity_Order = 0;
    private string $Entity_Name = '';
    private string $Entity_Data = '{}';
    private string $Entity_Created = '';
    private string $Entity_Modified = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->Entity_ID;
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return $this->Entity_ID_Parent;
    }

    /**
     * @param string $Entity_ID_Parent
     * @return Entity
     */
    public function setParent(string $Entity_ID_Parent): Entity
    {
        $this->Entity_ID_Parent = $Entity_ID_Parent;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->Entity_ID_Template;
    }

    /**
     * @param string $Entity_ID_Template
     * @return Entity
     */
    public function setTemplate(string $Entity_ID_Template): Entity
    {
        $this->Entity_ID_Template = $Entity_ID_Template;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginal(): string
    {
        return $this->Entity_ID_Original;
    }

    /**
     * @param string $Entity_ID_Original
     * @return Entity
     */
    public function setOriginal(string $Entity_ID_Original): Entity
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

    public function getCreated(): DateTime
    {
        return new DateTime($this->Entity_Created);
    }

    public function getModified(): DateTime
    {
        return new DateTime($this->Entity_Modified);
    }
}
