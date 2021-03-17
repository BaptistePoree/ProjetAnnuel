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
        //$this->styleSheetList[] = 'home';
        $this->styleSheetList[] = 'general';
    }

    public function makeProjectPage(){
        $this->title = "Liste des projet";
        ob_start();
        include('templates/projectPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    public function makeRankingsPage(){
        $this->title = "Classement";
        ob_start();
        include('templates/rankingsPage.php');
        $this->content .= ob_get_clean();
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
        $this->content .= '<form method="POST" action=".?action=createNewProject">';
        ob_start();
        include('templates/projectForm.php');
        $this->content .= ob_get_clean();
        $this->content .= '<input type="submit" name="create" value="Ajouter projet"></form></main>';
        $this->styleSheetList[] = 'general';
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

    public function makeInvestmentListPage($investmentList){
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

	public function render() {
        include("templates/top.php");
        echo $this->content;
        include("templates/bottom.php");
    }
}
?>