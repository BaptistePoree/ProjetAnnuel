<?php
require_once("model/ProjectStorage.php");

class Controller {

    protected $view;
    
	public function __construct(View $view) {
        $this->view = $view;
        $this->projectStorage = new ProjectStorage($this->view);
    }

    public function projectList(){
        $listOfProject = $this->projectStorage->getProjectsList();
        if($listOfProject != 'error'){
            $this->view->makeProjectListPage($listOfProject);
        }
    }

    public function showProject($projectId){
        $project = $this->projectStorage->getProject($projectId);
        if($project != 'error'){
            if($project != null){
                $this->view->makeShowProjectPage($project);
            }else{
                $this->view->makeErrorPage('Projet introuvable', 'Le projet demandé n\'existe pas');
            }
        }
    }

}

?>
