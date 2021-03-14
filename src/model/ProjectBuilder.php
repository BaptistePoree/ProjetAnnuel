<?php

class ProjectBuilder{
    protected $data;
    protected $errors;

    public function __construct($data = null) {
        $this->data = $data;
        $this->errors = array();
    }

    public function isValid(){

        //Nom de projet
        if (!key_exists("name", $this->data) || $this->data["name"] === "")
            $this->errors["name"] = "Vous devez saisir un nom de projet";
        else if (mb_strlen($this->data["name"], 'UTF-8') >= 100)
            $this->errors["lastName"] = "Le nom de projet doit faire moins de 100 caractères";

        //Description projet
        if (key_exists("description", $this->data))
            if (mb_strlen($this->data["description"], 'UTF-8') >= 255)
                $this->errors["description"] = "La description du projet doit faire moins de 255 caractères";

        //TO-DO: Image du projet
        
        
        return count($this->errors) === 0;
    }

    public function getErrors($ref) {
		return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
	}
    
    public function getData($ref) {
		return key_exists($ref, $this->data)? $this->data[$ref]: null;
    }

    public function buildProject(){
        $this->data['projectMember'] = json_encode($this->data['projectMember']);

        return new Project($this->data);
    }
}

?>