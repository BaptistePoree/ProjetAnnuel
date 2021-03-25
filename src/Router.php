<?php
require_once("view/View.php");
require_once("controller/Controller.php");


class Router {

	public function main() {
		$view = new View($this);
		$controller = new Controller($view);

		$action = key_exists('action', $_GET) ? $_GET['action'] : 'home';
		if(!key_exists('isLogged', $_SESSION)){
			$action = 'login';
		}

		try {
			switch ($action) {

			case "login":
				if(key_exists('login', $_POST)){
					$controller->login($_POST);
				}else{
					$view->makeLoginPage();
				}
				break;

			case "logout":
				$controller->logout();
				break;
				
			case "home":
                $view->makeHomePage();
				break;
				
			/*case "home":
				$controller->salonList();
				break;
			case 'createNewSalon':
				if(key_exists('create', $_POST)){
					$controller->createNewSalon($_POST);
				}else{
					$view->makeCreateNewSalonPage();
				}
			*/
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
				break;
			//}
			//if(){ on vérifie que la personne crowd-fouder 
			case "investmentList":
				$controller->investmentList();
				break;
			case "investing":
				if(key_exists('projectId', $_GET)){
					if(key_exists('investing', $_POST)){
						$controller->investing($_GET['projectId'], $_POST);
					}else{
						$controller->investing($_GET['projectId']);
					}
				}
				break;
			//}else if(){on vérifie que la personne professeur
			case "management":
				$view->makeManagementPage();
				break;

			case "projectsRanking":
				$controller->projectsRanking();
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
