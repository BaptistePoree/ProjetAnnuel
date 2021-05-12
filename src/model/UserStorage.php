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

    public function addUser($data){
        $surname = htmlspecialchars($data['surname']);
        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $password = sha1($data['password']);
        $key = htmlspecialchars($data['key']);

        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $req = $bd->prepare("INSERT INTO users(mail, password, firstName, lastName, idCles) VALUE(?, ?, ?, ?, ?)");

        try {
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $req->execute(array($email, $password, $name, $surname, $key));
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors de l\'inscription.', $e->getMessage());
        }
        
    }

    public function getUserById($userId){
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$rq = "SELECT * FROM users WHERE id = :userId";
		$stmt = $bd->prepare($rq);
		$data = array(":userId" => $userId);
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

    public function disableCanEditing($userId){
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$rq = "UPDATE users SET canInvest = 0 WHERE id = :userId";
		$stmt = $bd->prepare($rq);
		$data = array(":userId" => $userId);
        try{
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($stmt->execute($data)){
                return true;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        } 
    }
    
}
