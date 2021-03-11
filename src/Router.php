<?php
require_once("view/View.php");
require_once("controller/Controller.php");


class Router {

	public function main() {

		$view = new View($this);
		$controller = new Controller($view);

		$action = key_exists('action', $_GET) ? $_GET['action'] : 'accueil';

		try {
			switch ($action) {
			case "accueil":
                $view->makeHomePage();
                break;
        
			default:
				//TO-DO: Page defaut
				break;
			}
		} catch (Exception $e) {
			//TO-DO: Page d'erreur
		}
		$view->render();
	}

}

?>
