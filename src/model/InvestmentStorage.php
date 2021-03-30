<?php

require_once("model/Investment.php");

class InvestmentStorage{

    public function __construct(View $view = null) {
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

    public function getInvestmentList($userId){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT * FROM investments WHERE idUser = :idUser";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idUser" => $userId
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getSumOfAllInvestmentByGroup(){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT name, idProject, SUM(amount) FROM investments INNER JOIN projects ON investments.idProject = projects.id GROUP BY idProject ORDER BY SUM(amount) DESC";
            $stmt = $bd->prepare($rq);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getAllInvestmentOfProject($projectId){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT users.firstName, users.lastName, investments.idProject, investments.amount, investments.comment FROM investments INNER JOIN users ON investments.idUser = users.id WHERE investments.idProject = :projectId ORDER BY investments.amount DESC";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":projectId" => $projectId
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getTotalAmountInvested($userId){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT SUM(amount) FROM investments WHERE idUser = :idUser";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idUser" => $userId
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getTotalAmountInvestedExceptSpecifiedProject($userId, $projectId){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT SUM(amount) FROM investments WHERE idUser = :idUser AND idProject != :projectId";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idUser" => $userId,
                ":projectId" => $projectId
            );
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function exportAllInvestment(){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT projects.name, users.lastName, users.firstName, investments.amount, investments.comment FROM investments INNER JOIN projects ON investments.idProject = projects.id INNER JOIN users ON investments.idUser = users.id ORDER BY investments.idProject";
            $stmt = $bd->prepare($rq);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result != null){
                return $result;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

}
