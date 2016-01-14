<?php

class User
{
    private $username,$name,$surname,$position,$groupName;
//constructors
    function __construct()
    {
      $this->username='';
      $this->name='';
      $this->surname='';
      $this->position='';
      $this->group='';
    }

    /*function User($username,$name,$surname,$position)
    {
      $this->username=$username;
      $this->name=$name;
      $this->surname=$surname;
      $this->position=$position;
    }*/
    
//destructor
    function __destruct()
    {
        unset($this->username,$this->name,$this->surname,$this->position,$this->groupName);
    }
    
//getter
    public function getUsername()
    {
      return $this->username;
    }

    public function getName()
    {
      return $this->name;
    }

    public function getSurname()
    {
      return $this->surname;
    }

    public function getPosition()
    {
      return $this->position;
    }
    
    public function getGroup()
    {
        return $this->groupName;
    }
    
//setter
    public function setUsername($username)
    {
        $this->username=$username;
    }
    public function setName($name)
    {
        $this->name=$name;
    }
    public function setSurname($surname)
    {
        $this->surname=$surname;
    }
    public function setPosition($position)
    {
        $this->position=$position;
    }
    
    public function setGroup($groupName)
    {
        $this->groupName=$groupName;
    }
}

/*for further uses
class Employee extends User
{
    
}
*/

?>