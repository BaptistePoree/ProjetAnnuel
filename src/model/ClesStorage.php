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
            echo "<br> coucou";
            print_r($data);
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
            var_export($cles);
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
        
    }

    public function getListeClesRole(){
        try{

            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT role.nomRole, cles.idRole, cles.cles, cles.isValider FROM cles, role  WHERE role.id = cles.idRole";
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



}


?>