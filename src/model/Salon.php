<?php

class Salon{
    protected $id;
    protected $name;
    protected $description;
    protected $image;

    public function __construct($data = null){
        $this->id = (key_exists("id", $data))? $data["id"] : null;
        $this->name = (key_exists("name", $data))? $data["name"] : null;
        $this->description = (key_exists("description", $data))? $data["description"] : null;
        $this->image = (key_exists("image", $data))? $data["image"] : null;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getImage(){
        return $this->image;
    }
}

?>