<?php

class View {

	protected $router;
	protected $title;
    protected $content;
    protected $scriptList;
    protected $styleSheetList;

	public function __construct(Router $router) {
		$this->router = $router;
		$this->title = null;
        $this->content = null;
        $this->scriptList = array();
        $this->styleSheetList = array();
    }

    public function makeHomePage(){
        $this->title = "Accueil";
        ob_start();
        include('templates/homePage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
        $this->styleSheetList[] = 'general';
    }

    public function makeManagementPage(){
        $this->title = "Gestion";
        ob_start();
        include('templates/ManagementPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    function makeSalonListPage($listOfSalon){
        $this->title = "Liste des salons";
        ob_start();
        include('templates/homePage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
        $this->styleSheetList[] = 'general';
    }

    function makeProjectListPage($listOfProject){
        $this->title = "Liste des projets";
        ob_start();
        include('templates/projectList.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'projectList';
    }

    public function makeShowProjectPage($project){
        $this->title = "Projet - " . $project->getName();
        ob_start();
        include('templates/projectPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'projectPage';
    }

    public function makeErrorPage($title, $description){
        $this->title = "Erreur";
        ob_start();
        include('templates/errorPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    public function makeCreateNewProjectPage($projectBuilder = null){
        $this->title = "Ajouter un projet";
        $this->content .= '<main><a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  ';
        $this->content .= '<h2>Ajouter un projet</h2><form method="POST" action=".?action=createNewProject">';
        ob_start();
        include('templates/projectForm.php');
        $this->content .= ob_get_clean();
        $this->content .= '<input type="submit" name="create" value="Ajouter projet"></form></main>';
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'projectForm';
    }

    public function makeCreateNewSalonPage($salonBuilder = null){
        $this->title = "Ajouter un salon";
        $this->content .= '<main><a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  ';
        $this->content .= '<form method="POST" action=".?action=createNewSalon">';
        ob_start();
        include('templates/SalonForm.php');
        $this->content .= ob_get_clean();
        $this->content .= '<input type="submit" name="create" value="Ajouter un salon"></form></main>';
        $this->styleSheetList[] = 'general';
    }

    public function makeInvestingPage($project, $investmentBuilder=null){
        $this->title = "Investir";
        ob_start();
        include('templates/investmentPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'investingPage';
    }

    public function makeInvestmentListPage($investmentList, $totalAmountInvested, $maximumInvestment){
        $this->title = "Liste de mes investissement";
        ob_start();
        include('templates/investmentList.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'investmentList';
    }

    public function makeInvestmentSuccessPage($project){
        $this->title = "Investissement enregistré";
        ob_start();
        include('templates/investmentSuccess.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'investmentSuccess';
    }

    public function makeProjectsRankingPage($projectsRankingList = null){
        $this->title = "Classement des projets";
        ob_start();
        include('templates/projectsRanking.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'investmentList';
    }

    public function makeProjectsRankingDetailsPage($project = null, $allInvestmentOfProject = null){
        $this->title = "Détails des investissements";
        ob_start();
        include('templates/projectsRankingDetails.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'investmentList';
    }

    public function makeRegisterPage() {
        $this->title = "Inscription";
        ob_start();
        include('template/registerPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'register';
    }

    public function makeLoginPage($data = null){
        $this->title = "Connexion";
        ob_start();
        include('templates/loginPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'login';
    }

    public function makeAccessDeniedPage(){
        $this->title = "Accès refusé";
        ob_start();
        include('templates/accessDenied.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    public function makeParametrePage(){
        $this->title = "Parametre";
        ob_start();
        include('templates/parametre.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'parametreList';
    }

    public function makeParametreControlePage(){
        $this->title = "Parametre";
        ob_start();
        include('templates/parametreControle.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'parametreList';
    }

    public function makeParametreClesPage($listeClesRole = null, $clesBuilder = null){
        $this->title = "Parametre";
        $this->content .= '<main>';
        $this->content .= '<a href="?action=parametrePageGeneral" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>';
        $this->content .= '<h2> Parametre De Generation De Cles du Salon </h2>';
        ob_start();
        include('templates/parametreClesFrom.php');
        include('templates/parametreCles.php');
        $this->content .= ob_get_clean();
        $this->content .= '</main>';
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'parametreList';
    }

    public function makeParametreRolePage(){
        $this->title = "Parametre";
        ob_start();
        include('templates/parametreRole.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
        $this->styleSheetList[] = 'parametreList';
    }

	public function render() {
        include("templates/top.php");
        echo $this->content;
        include("templates/bottom.php");
    }
}
