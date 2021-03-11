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
    }

    public function makeProjectPage(){
        $this->title = "Liste des projet";
        ob_start();
        include('templates/projectPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
    }

    public function makeInvestementPage(){
        $this->title = "Mes investissements";
        ob_start();
        include('templates/InvestementPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
    }
    public function makeRankingsPage(){
        $this->title = "Classement";
        ob_start();
        include('templates/rankingsPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
    }
    public function makeManagementPage(){
        $this->title = "Gestion";
        ob_start();
        include('templates/ManagementPage.php');
        $this->content .= ob_get_clean();
        $this->styleSheetList[] = 'home';
    }

	public function render() {
        include("templates/top.php");
        echo $this->content;
        include("templates/bottom.php");
    }
}
?>