<?php

require_once("model/Cles.php");

class ClesStorage{

    public function __construct(View $view = null) {
        $this->view = $view;
    }

    public function addCles($cles){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "INSERT INTO cles (idRole, cles)  VALUES (:idRole, :cles)";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idRole" => $cles->getRole(),
                ":cles" => $cles->getCles()
            );
            if($stmt->execute($data)){
                return $bd->lastInsertId(); 
            }
        }
        catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
        catch(Exception $e)
        {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
        
    }

    public function getListeClesRole(){
        try{

            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT role.nomRole, cles.idRole, cles.id, cles.cles, cles.isValider FROM cles, role  WHERE role.id = cles.idRole";
            $stmt = $bd->query($rq);
            
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

    public function estUnique($cle) {
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $rq = $bd->prepare("SELECT * FROM cles WHERE cles = ?");
        $rq->execute(array($cle));
        return $rq->rowCount() == 0;
    }

    public function getListeCles(){
        try{

            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT cles.cles FROM cles";
            $stmt = $bd->query($rq);
            
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

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

    public function getIdRoleAndIdCles($cles){
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$rq = "SELECT idRole, idCles FROM cles WHERE cles = :cles";
		$stmt = $bd->prepare($rq);
		$data = array(":cles" => $cles);
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


?>