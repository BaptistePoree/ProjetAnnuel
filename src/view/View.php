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

    public function makeProjectPage(){
        $this->title = "Liste des projet";
        ob_start();
        include('templates/projectPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    public function makeInvestementPage(){
        $this->title = "Mes investissements";
        ob_start();
        include('templates/InvestementPage.php');
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

    function makeProjectListPage($listOfProject){
        $this->title = "Liste des projets";
        ob_start();
        include('templates/projectList.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
    }

    public function makeShowProjectPage($project){
        $this->title = "Projet - " . $project->getName();
        ob_start();
        include('templates/projectPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'general';
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
        $this->content .= '<main><form method="POST" action=".?action=createNewProject">';
        ob_start();
        include('templates/projectForm.php');
        $this->content .= ob_get_clean();
        $this->content .= '<input type="submit" name="create" value="Ajouter projet"></form></main>';
        $this->styleSheetList[] = 'general';
    }

	public function render() {
        include("templates/top.php");
        echo $this->content;
        include("templates/bottom.php");
    }
}
?>