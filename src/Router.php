<?php
require_once("view/View.php");
require_once("controller/Controller.php");


class Router {

	public function main() {

		$view = new View($this);
		$controller = new Controller($view);

		$action = key_exists('action', $_GET) ? $_GET['action'] : 'home';

		try {
			switch ($action) {
				/*
			case "home":
                $view->makeHomePage();
				break;
				*/
			case "home":
				$controller->salonList();
				break;
			case 'createNewSalon':
				if(key_exists('create', $_POST)){
					$controller->createNewSalon($_POST);
				}else{
					$view->makeCreateNewSalonPage();
				}
			//}
			//if(){ on vérifie que la personne est connecter
			case "project":
				$view->makeProjectPage();
				break;
			case "projectList":
				$controller->projectList();
				break;
			case 'showProject':
				if(key_exists('projectId', $_GET)){
					$controller->showProject($_GET['projectId']);
				}else{
					//TO-DO: Page erreur pas d'identifiant de projet placé en paramètre
				}
				break;
			case 'createNewProject':
				if(key_exists('create', $_POST)){
					$controller->createNewProject($_POST);
				}else{
					$view->makeCreateNewProjectPage();
				}
			//}
			//if(){ on vérifie que la personne crowd-fouder 
			case "investement":
				$view->makeInvestementPage();
				break;
			//}else if(){on vérifie que la personne professeur
			case "rankings":
				$view->makeRankingsPage();
				break;
			case "management":
				$view->makeManagementPage();
				break;
			//}			
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
