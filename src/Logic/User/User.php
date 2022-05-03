<?php

namespace Pars\Logic\User;

use DateTime;

class User
{
    private string $User_ID = '';
    private string $User_Name = '';
    private string $User_Password = '';
    private string $User_Data = '{}';
    private string $User_Created = '';
    private string $User_Modified = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->User_ID;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->User_Name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->User_Name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->User_Password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->User_Password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->User_Data;
    }

    /**
     * @param string $data
     * @return User
     */
    public function setData(string $data): User
    {
        $this->User_Data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataArray(): array
    {
        return json_decode($this->User_Data, true);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setDataArray(array $data): User
    {
        $this->User_Data = json_encode($data);
        return $this;
    }

    public function getCreated(): DateTime
    {
        return new DateTime($this->User_Created);
    }

    public function getModified(): DateTime
    {
        return new DateTime($this->User_Modified);
    }
}
