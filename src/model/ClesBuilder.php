<?php

class ClesBuilder{

    protected $data;
    protected $errors;

    public function __construct($data = null) {
        $this->data = $data;
        $this->errors = array();
    }

    public function isValid(){

        //role choisi
        if (!key_exists("roleChoisi", $this->data) 
                || $this->data["roleChoisi"] === "" 
                || $this->data["roleChoisi"] === "0"
            )
            $this->errors["roleChoisi"] = "Vous devez choisir un role dans la liste";

        // //nombre de cles
        // if (key_exists("nombreDeCles", $this->data))
        //     if (mb_strlen($this->data["nombreDeCles"], 'UTF-8')> 3 && is_int($this->data["nombreDeCles"]))
        //         $this->errors["nombreDeCles"] = "le nombre de cles doit etre un nombre entier et conpris entre 1 et 99";      
        
        return count($this->errors) === 0;
    }

    public function getErrors($ref) {
    return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
    }

    public function getData($ref) {
        return key_exists($ref, $this->data)? $this->data[$ref]: null;
    }

    public function buildCles(){
        $this->data["idRole"] = $this->data["roleChoisi"];
        // TO-DO: generer une cles aleroire
        $this->data["cles"] = bin2hex(random_bytes(15));
        return new Cles($this->data);
    }

    public function isValidClesVsListe(string $clesTester, array $listeCles) :bool{
        return in_array($clesTester, $listeCles);
    }

}


?>