<?php

class SalonStorage{

    public function __construct($view) {
        $this->view = $view;
    }

    public function getSalon($id){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT * FROM salon WHERE id = :id";
            $stmt = $bd->prepare($rq);
            $data = array(":id" => $id);
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 1){
                $result = $result[0];
                $salon = new Salon($result);
                return $salon;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }  
    
    public function getSalonList(){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT id, name FROM salon";
            $stmt = $bd->prepare($rq);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 0){
                return null;
            }else{
                return $result;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function addSalon($salon){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "INSERT INTO salon (name, description)  VALUES (:name, :description)";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":name" => $salon->getName(),
                ":description" => $salon->getDescription(),
            );
            if($stmt->execute($data)){
                return $bd->lastInsertId(); 
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }
}
