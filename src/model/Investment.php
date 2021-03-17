<?php

class Investment{
    protected $id;
    protected $idProject;
    protected $idUser;
    protected $amount;
    protected $comment;

    public function __construct($data = null){
        $this->id = (key_exists("id", $data))? $data["id"] : null;
        $this->idProject = (key_exists("idProject", $data))? $data["idProject"] : null;
        $this->idUser = (key_exists("idUser", $data))? $data["idUser"] : null;
        $this->amount = (key_exists("amount", $data))? $data["amount"] : null;
        $this->comment = (key_exists("comment", $data))? $data["comment"] : null;
    }

    public function getId(){
        return $this->id;
    }

    public function getIdProject(){
        return $this->idProject;
    }

    public function getIdUser(){
        return $this->idUser;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function getComment(){
        return $this->comment;
    }
    
}

?>