<?php

class User{
    protected $id;
    protected $mail;
    protected $password;
    protected $firstName;
    protected $lastName;
    protected $role;

    public function __construct($data = null){
        $this->id = (key_exists("id", $data))? $data["id"] : null;
        $this->mail = (key_exists("mail", $data))? $data["mail"] : null;
        $this->password = (key_exists("password", $data))? $data["password"] : null;
        $this->firstName = (key_exists("firstName", $data))? $data["firstName"] : null;
        $this->lastName = (key_exists("lastName", $data))? $data["lastName"] : null;
        $this->role = (key_exists("role", $data))? $data["role"] : null;
    }

    public function getId(){
        return $this->id;
    }

    public function getMail(){
        return $this->mail;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getFirstName(){
        return $this->firstName;
    }

    public function getLastName(){
        return $this->lastName;
    }

    public function getRole(){
        return $this->role;
    }
}

?>