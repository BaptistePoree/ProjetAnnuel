<?php

class UserStorage{

    public function __construct($view) {
        $this->view = $view;
    }

    public function getUser($mail){
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$rq = "SELECT * FROM users WHERE mail = :mail";
		$stmt = $bd->prepare($rq);
		$data = array(":mail" => $mail);
        try{
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 0){
                return null;
            }else{
                return new User($result[0]);
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }
    
}
