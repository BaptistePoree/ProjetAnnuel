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

	public function render() {
        include("templates/top.php");
        echo $this->content;
        include("templates/bottom.php");
    }
}
?>