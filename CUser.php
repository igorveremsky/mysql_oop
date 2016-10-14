<?php
/**
 * Interface IUser
 */
interface IUser {
    /**
     * @return mixed
     */
    function getFirstName();

    /**
     * @return mixed
     */
    function getLastName();

    /**
     * @return mixed
     */
    function getAge();

    /**
     * @return mixed
     */
    function getBirthDate();
}

/**
 * Class User
 */
class User implements IUser
{
    private $_first_name;
    private $_last_name;
    private $_age;
    private $_birth_date;

    /**
     * @param $_first_name
     * @param $_last_name
     * @param $_age
     * @param $_birth_date
     */
    function __construct($_first_name, $_last_name, $_age, $_birth_date)
    {
        $this->_first_name = $_first_name;
        $this->_last_name = $_last_name;
        $this->_age = $_age;
        $this->_birth_date = $_birth_date;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->_birth_date;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_last_name;
    }
}