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
require_once("model/RoleStorage.php");



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
        $this->roleStorage = new RoleStorage($this->view);
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

    public function showProject($projectId, $msg = null)
    {
        $project = $this->projectStorage->getProject($projectId);
        if ($project != 'error') {
            if ($project != null) {
                $this->view->makeShowProjectPage($project, $msg);
            } else {
                $this->view->makeErrorPage('Projet introuvable', 'Le projet demandé n\'existe pas');
            }
        }
    }

    public function createNewProject($data, $onEdit = false)
    {
        $projectBuilder = new ProjectBuilder($data);
        if ($projectBuilder->isValid()) {
            $project = $projectBuilder->buildProject();
            if($onEdit){
                $response = $this->projectStorage->modifyProject($project, $data['projetId']);
                $msg = "Le projet a bien été mis à jour!";
            } else {
                $response = $this->projectStorage->addProject($project);
                $msg = "Le projet a bien été créé!";
            }
            if ($response != 'error') {
                $this->showProject($response, $msg);
                //TO-DO: Pour l'instant une fois ajouter, est affiché la page du projet qui vient d'être créer. Peut-être à la place un page indiquant que le projet à bien été ajouté, et 3 boutons: -Voir fiche projet, -ajouter un autre projet, -retourner à l'accueil
            }
        } else {
            $this->view->makeCreateNewProjectPage($projectBuilder);
        }
    }

    public function openEditProjet($data)
    {
        $project = $this->projectStorage->getProject($data['projetId']);
        $projectData = array(
            "name" => $project->getName(),
            "description" => $project->getDescription(),
        );
        $projectBuilder = new ProjectBuilder($projectData);
        $this->view->makeCreateNewProjectPage($projectBuilder, true);
    }

    public function modifyProject($data, $projetId){
        $data['projetId'] = $projetId['projetId'];
        $this->createNewProject($data, true);
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
                $this->view->makeHomePage(true);
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

    public function suprimerCles($data)
    {
        print_r($data);
        $listeCles = $data['delete'];
        if (key_exists('delete', $data)) {
            foreach ($listeCles as $idCles) {
                echo $idCles . "  ";
                $response = 'ok';
                $response = $this->clesStorage->suprimerCles($idCles);
            }
            if ($response != 'error') {
                $this->parametreClesPage();
            }
        } else {
            $this->parametreClesPage();
        }
    }

    public function exportClesCrowFondeur()
    {
        $allClesCrowFondeur = $this->clesStorage->exportCles(2);
        
        if ($allClesCrowFondeur != null) {
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="ClesCrowFondeur.csv";');
            $f = fopen('php://output', 'w');
            foreach ($allClesCrowFondeur as $investment) {
                fputcsv($f, $investment, ";");
            }
            exit;
        }
    }

    public function parametre($type = null)
    {
        if ($type != null) 
        {
            $data = ['titre' => $type, 'core' => ''];
            $data['core'] ='<form method="POST" action=".?action='.$type.'">';
            $data['core'].='<p>';
            if ($type == "Plafon")
            { 
                $plafonMax = $this->settingsStorage->getSettings('maximumInvestment')['value']/1000;

                $data['titrePage'] = "du Plafond des Investissement du salon"; 

                $data['core'].= 'Le ' . $type . ' est un multiple de 1000, donc saisier un chifre qui sera multipler par 1000 (chifre * 1000) : '; 
                $data['core'].= '<input id="number" type="text" name="plafond_num" value="'.$plafonMax.'" min="0">';
                $data['core'].= '<input type="submit" name="' . $type . '" value="' . $type . '" id="butonUnique">' ;
            
            }
            elseif ($type == "Clean")
            { 
                $data['titrePage'] = "de ".$type." des Investissement du salon"; 

                $data['core'].= 'Le ' . $type . ' est la pour effacer tout les investissement fait dans le salon : '; 
                $data['core'].= '<input type="submit" name="' . $type . '" value="' . $type . '" id="butonUnique">' ;
            }
            elseif ($type === "Investissement")
            { 
                if ($this->roleStorage->isInvestisementOuvert())
                { if ($this->userStorage->convertionCanEditing(1))
                    { $etatSalon = 'Ouvert'; }
                }
                else
                { if ($this->userStorage->convertionCanEditing(0))
                    { $etatSalon = 'Fermer'; }
                }
                $data['titrePage'] = 'des '.$type; 

                $data['core'].= 'Les ' . $type . ' sont : '; 
                $data['core'].= '<input type="submit" name="' . $type . '" value="' . $etatSalon . '" id="butonUnique">' ;
            }
            $data['core'].= ' </p>' ;
            $data['core'].= ' </from>' ;
            $this->view->makeParametreSalonPage($data);
        }
        else
        { $this->view->makeParametreControlePage(); }
    }

    public function parameterPlafond($plafond = 0)
    {        
        $plafondK = $plafond*1000;
        $this->settingsStorage->changerSettings($plafondK);
        $this->view->makeParametreControlePage();
    }

    public function parameterClean()
    {
        $this->investmentStorage->deleteInvestment();
        $this->view->makeParametreControlePage();
    }

    public function parameterInvestissement($etatSalon)
    {
        if ($etatSalon === 'Ouvert')
        { $this->roleStorage->convertionInsvestire(0); }
        else
        { $this->roleStorage->convertionInsvestire(1); }
        $this->view->makeParametreControlePage();
    }


    public function register($data)
    {
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
                    $data['idCles'] = $this->clesStorage->getId($data['cles']);
                    $this->userStorage->addUser($data);
                    $this->clesStorage->setValid($data['cles']);
                    $this->view->makeLoginPage($data, true);
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
                    $password = sha1($data['password']); // chiffrement du mdp avec sha1();
                    if ($password === $user->getPassword()) { // compare les deux chaines au lieu de verify_password();
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
