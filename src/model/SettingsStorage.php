<?php

class SettingsStorage{

    public function __construct() {
        
    }

    public function getSettings($settingName){
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

}
