<?php

class SettingsStorage{

    public function __construct() {
        
    }

    public function getSettings($settingName = "maximumInvestment"){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT value FROM settings WHERE parameter = :settingName";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":settingName" => $settingName
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 1){
                $result = $result[0];
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            return 'null';
        }
    }

    public function changerSettings($nouveauPlafon)
    {
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $rq = "UPDATE settings SET value = $nouveauPlafon WHERE id = 1";
        $stmt = $bd->prepare($rq);
        $data = array();
        try {
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($stmt->execute($data)) {
                return true;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

}
