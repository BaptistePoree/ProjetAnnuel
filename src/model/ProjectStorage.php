<?php

require_once("model/Project.php");

class ProjectStorage{

    public function __construct($view) {
        $this->view = $view;
    }

    public function getProject($id){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT * FROM projects WHERE id = :id";
            $stmt = $bd->prepare($rq);
            $data = array(":id" => $id);
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($result) === 1){
                $result = $result[0];
                $project = new Project($result);
                return $project;
            }else{
                return null;
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }  
    
    public function getProjectsList(){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT id, name FROM projects";
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

    public function addProject($project){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "INSERT INTO projects (name, description)  VALUES (:name, :description)";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":name" => $project->getName(),
                ":description" => $project->getDescription(),
            );
            if($stmt->execute($data)){
                return $bd->lastInsertId(); 
            }
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function modifyProject($project, $projectId){
        try {
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "UPDATE projects SET name = ?, description = ? WHERE id = ?";
            $stmt = $bd->prepare($rq);
            $data = array(
                $project->getName(),
                $project->getDescription(),
                $projectId,
            );
            if ($stmt->execute($data)) {
                return $projectId;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function deleteProjet($projectId){
        try {
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "DELETE FROM projects WHERE id = ?";
            $stmt = $bd->prepare($rq);
            $data = array(
                $projectId,
            );
            if ($stmt->execute($data)) {
                return $projectId;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }
}
