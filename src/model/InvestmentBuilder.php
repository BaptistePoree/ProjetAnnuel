<?php
require_once("model/SettingsStorage.php");
require_once("model/InvestmentStorage.php");
require_once("model/Investment.php");

class InvestmentBuilder{
    protected $data;
    protected $errors;

    public function __construct($data = null) {
        $this->data = $data;
        $this->errors = array();
    }

    public function getMaximumInvestmentValue(){
        $settingsStorage = new SettingsStorage();
        $maximumInvestment = $settingsStorage->getSettings('maximumInvestment');
        if($maximumInvestment == null){
            $maximumInvestment = 0;
        }
        return intval($maximumInvestment['value']);
    }

    public function getTotalAmountInvested(){
        $investmentStorage = new InvestmentStorage();
        if($this->data['investing'] == 'edit'){
            $totalAmountInvested = $investmentStorage->getTotalAmountInvestedExceptSpecifiedProject($_SESSION['userId'], $this->data['idProject']);
        }else{
            $totalAmountInvested = $investmentStorage->getTotalAmountInvested($_SESSION['userId']);
        }
        if($totalAmountInvested != 'error'){
            if($totalAmountInvested != null){
                $totalAmountInvested = intval($totalAmountInvested[0]['SUM(amount)']);
            }
        }else{
            $totalAmountInvested = 0;
        }
        return $totalAmountInvested;
    }

    public function getAvailableBalance(){   
        //on récupère le montant déja investi dans le projet si il esxiste
        return $this->getMaximumInvestmentValue() - $this->getTotalAmountInvested();
    }

    public function isValid(){

        //Montant investi 
        if (key_exists("amount", $this->data))
            if(!preg_match("/^[0-9]*000$/i", $this->data['amount'])){
                $this->errors["amount"] = "Un investissement doit forcément être un entier positif et être un multiple de 1000";
            }else if($this->data['amount'] > $this->getAvailableBalance()){
                $alwaysInvested = $this->getTotalAmountInvested();
                $maximumInvestment = $this->getMaximumInvestmentValue();
                $this->errors["amount"] = "Vous ne pouvez pas investir cette somme; Vous avez déjà investi " . number_format($alwaysInvested, 0, ',', ' ') . "€ sur " . number_format($maximumInvestment, 0, ',', ' ') . "€. Il ne vous reste que " . number_format(($maximumInvestment - $alwaysInvested), 0, ',', ' ') . "€ à investir.";
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