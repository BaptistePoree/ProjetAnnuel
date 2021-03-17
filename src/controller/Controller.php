<?php
require_once("model/ProjectStorage.php");
require_once("model/ProjectBuilder.php");
require_once("model/SalonStorage.php");
require_once("model/SalonBuilder.php");
require_once("model/Investment.php");
require_once("model/InvestmentStorage.php");
require_once("model/InvestmentBuilder.php");


class Controller {

    protected $view;
    
	public function __construct(View $view) {
        $this->view = $view;
        $this->projectStorage = new ProjectStorage($this->view);
        $this->salonStorage = new SalonStorage($this->view);
        $this->investmentStorage = new InvestmentStorage($this->view);
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

    public function investing($projectId, $investmentPOSTData = null){
        //on récupère le projet
        $project = $this->projectStorage->getProject($projectId);
        //On récupère si un investissement existe déjà sur le projet placé en paramètre
        $investment = $this->investmentStorage->getInvestmentByProjectIdAndUserId($projectId, $_SESSION['userId']);
        if($investment != 'error' && $project != 'error'){
            //On check si un formulaire à été renvoyé ou non
            if($investmentPOSTData != null){
                if($investmentPOSTData['investing'] == 'add'){
                    $investmentPOSTData['idUser'] = $_SESSION['userId'];
                    $investmentPOSTData['idProject'] = $projectId;
                    $investmentBuilder = new InvestmentBuilder($investmentPOSTData);
                    if($investmentBuilder->isValid()){
                        $investment = $investmentBuilder->buildInvestment();
                        $addInvestment = $this->investmentStorage->addInvestment($investment);
                        if($addInvestment != 'error'){
                            echo "Ajouté avec succès";
                            //TO-DO: redirection vers page "propre" avec message investissement ajouter 
                        }
                    }else{
                        $this->view->makeInvestingPage($project, $investmentBuilder);
                    }
                }
                if($investmentPOSTData['investing'] == 'edit'){
                    if($investment != null){
                        $investmentPOSTData['id'] = $investment->getId();
                        $investmentPOSTData['idUser'] = $investment->getIdUser();
                        $investmentPOSTData['idProject'] = $investment->getIdProject();
                        $investmentBuilder = new InvestmentBuilder($investmentPOSTData);
                        if($investmentBuilder->isValid()){
                            $investment = $investmentBuilder->buildInvestment();
                            $editInvestment = $this->investmentStorage->editInvestment($investment);
                            if($editInvestment == true){
                                echo "Modifié avec succès";
                                //TO-DO: redirection vers page "propre" avec message investissement modifié     
                            }
                        }else{
                            $this->view->makeInvestingPage($project, $investmentBuilder);
                        }
                    }else{
                        //TO-DO: Erreur
                    }
                }
            }else{
                //Si aucun investissement n'existe on affiche un formulaire vierge
                if($investment == null){
                    $this->view->makeInvestingPage($project);
                }else{
                    //Sinon on affiche le fomulaire rempli avec l'investissement associé
                    $investmentBuilder = new InvestmentBuilder();
                    $investmentBuilder = $investmentBuilder->buildFromInvestmentObject($investment);
                    $this->view->makeInvestingPage($project, $investmentBuilder);
                }
            }
        }
    }

}

?>
