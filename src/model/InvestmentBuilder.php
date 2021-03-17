<?php

class InvestmentBuilder{
    protected $data;
    protected $errors;

    public function __construct($data = null) {
        $this->data = $data;
        $this->errors = array();
    }

    public function isValid(){

        //Montant investi 
        if (key_exists("amount", $this->data))
            if(!preg_match("/^[0-9.]*$/i", $this->data['amount'])){
                $this->errors["amount"] = "Un investissement doit forcément être un entier positif";
            }

        //Commentaire
        if (key_exists("comment", $this->data))
            if (mb_strlen($this->data["comment"], 'UTF-8') >= 255)
                $this->errors["comment"] = "Un commentaire doit faire moins de 255 caractères";
        
        
        return count($this->errors) === 0;
    }

    public function getErrors($ref) {
		return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
	}
    
    public function getData($ref) {
		return key_exists($ref, $this->data)? $this->data[$ref]: null;
    }

    public function buildFromInvestmentObject($investment){
        return new InvestmentBuilder(array(
			"id" => $investment->getId(),
			"idProject" => $investment->getIdProject(),
            "idUser" => $investment->getIdUser(),
            "amount" => $investment->getAmount(),
            "comment" => $investment->getComment(),
		));
    }

    public function buildInvestment(){
        return new Investment($this->data);
    }
}

?>