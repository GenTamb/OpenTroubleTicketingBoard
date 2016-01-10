<?php

class User
{
    private $username,$name,$surname,$position;
//constructors
    function __construct()
    {
      $this->username='';
      $this->name='';
      $this->surname='';
      $this->position;
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
        unset($this->username,$this->name,$this->surname,$this->position);
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
}
/*for further uses
class Employee extends User
{
    
}
*/

?>