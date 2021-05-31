<?php
require_once("model/ProjectStorage.php");
require_once("model/ProjectBuilder.php");
//require_once("model/SalonStorage.php");
//require_once("model/SalonBuilder.php");
require_once("model/Investment.php");
require_once("model/InvestmentStorage.php");
require_once("model/InvestmentBuilder.php");
require_once("model/User.php");
require_once("model/UserStorage.php");
require_once("model/SettingsStorage.php");
//require_once("model/UserInvestments.php");
require_once("model/ClesStorage.php");
require_once("model/ClesBuilder.php");


class Controller
{

    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
        $this->projectStorage = new ProjectStorage($this->view);
        //$this->salonStorage = new SalonStorage($this->view);
        $this->investmentStorage = new InvestmentStorage($this->view);
        $this->userStorage = new UserStorage($this->view);
        $this->settingsStorage = new SettingsStorage();
        $this->clesStorage = new ClesStorage($this->view);
    }
    /*
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
            
        }else{
            $this->view->makeCreateNewSalonPage($salonBuilder);
        }
    }
*/
    public function projectList()
    {
        $listOfProject = $this->projectStorage->getProjectsList();
        if ($listOfProject != 'error') {
            $this->view->makeProjectListPage($listOfProject);
        }
    }

    public function showProject($projectId)
    {
        $project = $this->projectStorage->getProject($projectId);
        if ($project != 'error') {
            if ($project != null) {
                $this->view->makeShowProjectPage($project);
            } else {
                $this->view->makeErrorPage('Projet introuvable', 'Le projet demandé n\'existe pas');
            }
        }
    }

    public function createNewProject($data)
    {
        $projectBuilder = new ProjectBuilder($data);
        if ($projectBuilder->isValid()) {
            $project = $projectBuilder->buildProject();
            $response = $this->projectStorage->addProject($project);
            if ($response != 'error') {
                $this->showProject($response);
                //TO-DO: Pour l'instant une fois ajouter, est affiché la page du projet qui vient d'être créer. Peut-être à la place un page indiquant que le projet à bien été ajouté, et 3 boutons: -Voir fiche projet, -ajouter un autre projet, -retourner à l'accueil
            }
        } else {
            $this->view->makeCreateNewProjectPage($projectBuilder);
        }
    }

    public function canInvest()
    {
        $user = $this->userStorage->getUserById($_SESSION['userId']);
        if ($user->getCanInvest() == false) {
            $this->view->makeErrorPage('Vous ne pouvez pas investir', 'Vous avez validé votre feuille d\'investissement, vous ne pouvez donc plus investir.');
            return false;
        }
        //TO-DO: Vérifier également si les paramètre du serveur autorise l'investissement
        return true;
    }

    public function investing($projectId, $investmentPOSTData = null)
    {
        //On regarde si l'utilisateur peux investir
        if ($this->canInvest()) {
            //on récupère le projet
            $project = $this->projectStorage->getProject($projectId);
            //On récupère si un investissement existe déjà sur le projet placé en paramètre
            $investment = $this->investmentStorage->getInvestmentByProjectIdAndUserId($projectId, $_SESSION['userId']);
            if ($investment != 'error' && $project != 'error') {
                //On check si un formulaire à été renvoyé ou non
                if ($investmentPOSTData != null) {
                    if ($investmentPOSTData['investing'] == 'add') {
                        $investmentPOSTData['idUser'] = $_SESSION['userId'];
                        $investmentPOSTData['idProject'] = $projectId;
                        $investmentBuilder = new InvestmentBuilder($investmentPOSTData);
                        if ($investmentBuilder->isValid()) {
                            $investment = $investmentBuilder->buildInvestment();
                            $addInvestment = $this->investmentStorage->addInvestment($investment);
                            if ($addInvestment != 'error') {
                                $this->view->makeInvestmentSuccessPage($project);
                            }
                        } else {
                            $this->view->makeInvestingPage($project, $investmentBuilder);
                        }
                    }
                    if ($investmentPOSTData['investing'] == 'edit') {
                        if ($investment != null) {
                            $investmentPOSTData['id'] = $investment->getId();
                            $investmentPOSTData['idUser'] = $investment->getIdUser();
                            $investmentPOSTData['idProject'] = $investment->getIdProject();
                            $investmentBuilder = new InvestmentBuilder($investmentPOSTData);
                            if ($investmentBuilder->isValid()) {
                                $investment = $investmentBuilder->buildInvestment();
                                $editInvestment = $this->investmentStorage->editInvestment($investment);
                                if ($editInvestment == true) {
                                    $this->view->makeInvestmentSuccessPage($project);
                                }
                            } else {
                                $this->view->makeInvestingPage($project, $investmentBuilder);
                            }
                        } else {
                            //TO-DO: Erreur
                        }
                    }
                } else {
                    //Si aucun investissement n'existe on affiche un formulaire vierge
                    if ($investment == null) {
                        $this->view->makeInvestingPage($project);
                    } else {
                        //Sinon on affiche le fomulaire rempli avec l'investissement associé
                        $investmentBuilder = new InvestmentBuilder();
                        $investmentBuilder = $investmentBuilder->buildFromInvestmentObject($investment);
                        $this->view->makeInvestingPage($project, $investmentBuilder);
                    }
                }
            }
        }
    }

    public function investmentList()
    {
        $investmentList = $this->investmentStorage->getInvestmentList($_SESSION['userId']);
        $totalAmountInvested = $this->investmentStorage->getTotalAmountInvested($_SESSION['userId']);
        $maximumInvestment = $this->settingsStorage->getSettings('maximumInvestment');
        if ($investmentList != 'error' && $totalAmountInvested != 'error') {
            $maximumInvestment = ($maximumInvestment == null) ? 0 : $maximumInvestment['value'];
            $this->view->makeInvestmentListPage($investmentList, $totalAmountInvested, $maximumInvestment);
        }
    }

    public function validateInvestments()
    {
        $maximumInvestment = $this->settingsStorage->getSettings('maximumInvestment');
        $totalAmountInvested = $this->investmentStorage->getTotalAmountInvested($_SESSION['userId']);
        if ($maximumInvestment != 'error' && $totalAmountInvested != 'error') {
            if ($maximumInvestment['value'] != $totalAmountInvested[0]['SUM(amount)']) {
                $this->view->makeErrorPage('Vous ne pouvez pas valider vos investissements', 'Vous ne pouvez pas valider vos investissements car il vous reste ' . ($maximumInvestment['value'] - $totalAmountInvested[0]['SUM(amount)']) . '€ à investir.');
            } else {
                $this->userStorage->disableCanEditing($_SESSION['userId']);
                //TO-DO: Page propre avec "Vous avez validez vos investissements
                $this->view->makeHomePage();
            }
        }
    }

    public function projectsRanking()
    {
        $projectsRanking = $this->investmentStorage->getSumOfAllInvestmentByGroup();
        if ($projectsRanking != 'error') {
            $this->view->makeProjectsRankingPage($projectsRanking);
        }
    }

    public function projectsRankingDetails($projectId)
    {
        $project = $this->projectStorage->getProject($projectId);
        if ($project != 'error') {
            if ($project != null) {
                $allInvestmentOfProject = $this->investmentStorage->getAllInvestmentOfProject($projectId);
                if ($allInvestmentOfProject != 'error') {
                    $this->view->makeProjectsRankingDetailsPage($project, $allInvestmentOfProject);
                }
            } else {
                $this->view->makeErrorPage('Projet introuvable', 'Le projet demandé n\'existe pas');
            }
        }
    }

    public function exportAllInvestment()
    {
        $allInvestments = $this->investmentStorage->exportAllInvestment();
        if ($allInvestments != null) {
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="Investissements.csv";');
            $f = fopen('php://output', 'w');
            foreach ($allInvestments as $investment) {
                fputcsv($f, $investment, ";");
            }
            exit;
        }
    }

    public function parametreClesPage()
    {
        $listeClesRole = $this->clesStorage->getListeClesRole();
        $this->view->makeParametreClesPage($listeClesRole);
    }

    public function createNewCles($data)
    {
        $clesBuilder = new ClesBuilder($data);
        if ($clesBuilder->isValid()) {
            $cles = $clesBuilder->buildCles();
            while (!$this->clesStorage->estUnique($cles->getCles())) {
                $cles = $clesBuilder->buildCles();
            }
            $response = $this->clesStorage->addCles($cles);
            if ($response != 'error') {
                $this->parametreClesPage();
            }
        } else {
            $this->parametreClesPage();
        }
    }

    public function register($data)
    {
        var_export($data);
        if (
            key_exists('firstName', $data)
            && key_exists('lastName', $data)
            && key_exists('mail', $data)
            && key_exists('password', $data)
            && key_exists('cles', $data)
        ) {
            $user = $this->userStorage->getUser($data['mail']);
            if ($user == null) {
                if ($this->clesStorage->isValide($data['cles'])) {
                    $data['idRole'] = $this->clesStorage->getRoleByCle($data['cles']);
                    $this->userStorage->addUser($data);
                    $this->view->makeLoginPage($data);
                } else {
                    $this->view->makeRegisterPage();
                }
            } else {
                $this->view->makeRegisterPage();
            }
        } else {
            $this->view->makeRegisterPage();
        }
    }

    public function login($data)
    {
        if (key_exists('mail', $data) && key_exists('password', $data)) {
            $user = $this->userStorage->getUser($data['mail']);
            if ($user != 'error') {
                if ($user != null) {
                    if (password_verify($data['password'], $user->getPassword())) {
                        $_SESSION['isLogged'] = true;
                        $_SESSION['userId'] = $user->getId();
                        $_SESSION['role'] = $user->getRole();
                        $this->view->makeHomePage();
                    } else {
                        $this->view->makeLoginPage($data);
                    }
                } else {
                    $this->view->makeLoginPage($data);
                }
            }
        } else {
            $this->view->makeLoginPage($data);
        }
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION);
        $this->view->makeLoginPage();
    }
}
