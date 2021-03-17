<?php

require_once("model/Investment.php");

class InvestmentStorage{

    public function __construct(View $view) {
        $this->view = $view;
    }

    public function getInvestmentByProjectIdAndUserId($projectId, $userId){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT * FROM investments WHERE idProject = :idProject AND idUser = :idUser";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idProject" => $projectId,
                ":idUser" => $userId
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 1){
                $result = $result[0];
                $investment = new Investment($result);
                return $investment;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function addInvestment($investment){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "INSERT INTO investments (idProject, idUser, amount, comment)  VALUES (:idProject, :idUser, :amount, :comment)";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idProject" => $investment->getIdProject(),
                ":idUser" => $investment->getIdUser(),
                ":amount" => $investment->getAmount(),
                ":comment" => $investment->getComment()
            );
            if($stmt->execute($data)){
                return $bd->lastInsertId(); 
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function editInvestment($investment){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "UPDATE investments SET amount=:amount, comment=:comment WHERE id = :id";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":id" => $investment->getId(),
                ":amount" => $investment->getAmount(),
                ":comment" => $investment->getComment()
            );
            if($stmt->execute($data)){
                return true;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        } 
    }

}
