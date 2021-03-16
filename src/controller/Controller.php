<?php
require_once("model/ProjectStorage.php");
require_once("model/ProjectBuilder.php");
require_once("model/SalonStorage.php");
require_once("model/SalonBuilder.php");

class Controller {

    protected $view;
    
	public function __construct(View $view) {
        $this->view = $view;
        $this->projectStorage = new ProjectStorage($this->view);
        $this->salonStorage = new SalonStorage($this->view);
    }

    public function salonList(){
        $listOfSalon = $this->salonStorage->getSalonList();
        if($listOfSalon != 'error'){
            $this->view->makeSalonListPage($listOfSalon);
        }
    }

    public function createNewSalon($data){
        $salonBuilder = new SalonBuilder($data);
        if($salonBuilder->isValid()){
            $salon = $salonBuilder->buildSalon();
            $response = $this->salonStorage->addSalon($salon);
            /*
            if($response!= 'error'){
                $this->showSalon($response);
                //TO-DO: Pour l'instant une fois ajouter, est affiché la page du salon qui vient d'être créer. Peut-être à la place un page indiquant que le salon à bien été ajouté, et 3 boutons: -Voir fiche salon, -ajouter un autre salon, -retourner à l'accueil
            }
            */
        }else{
            $this->view->makeCreateNewSalonPage($salonBuilder);
        }
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

    public function createNewProject($data){
        $projectBuilder = new ProjectBuilder($data);
        if($projectBuilder->isValid()){
            $project = $projectBuilder->buildProject();
            $response = $this->projectStorage->addProject($project);
            if($response!= 'error'){
                $this->showProject($response);
                //TO-DO: Pour l'instant une fois ajouter, est affiché la page du projet qui vient d'être créer. Peut-être à la place un page indiquant que le projet à bien été ajouté, et 3 boutons: -Voir fiche projet, -ajouter un autre projet, -retourner à l'accueil
            }
        }else{
            $this->view->makeCreateNewProjectPage($projectBuilder);
        }
    }

}

?>
