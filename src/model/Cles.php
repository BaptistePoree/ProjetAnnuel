<?php

class Cles{
    protected $id;
    protected $role;
    protected $cles;

    public function __construct($data = null){
        $this->id = (key_exists("id", $data))? $data["id"] : null;
        $this->role = (key_exists("idRole", $data))? $data["idRole"] : null;
        $this->cles = (key_exists("cles", $data))? $data["cles"] : null;
    }

    public function getId(){
        return $this->id;
    }

    public function getRole(){
        return $this->role;
    }

    public function getCles(){
        return $this->cles;
    }

    public function __toString(){
        return $this->getId() + " " + $this->getRole() + " " + $this->getCles(); 
    }

}

?>