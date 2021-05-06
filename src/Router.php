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
				if($_SESSION['role'] == 1){
					if(key_exists('create', $_POST)){
						$controller->createNewProject($_POST);
					}else{
						$view->makeCreateNewProjectPage();
					}
				}else{
					$view->makeAccessDeniedPage();
				}
				break;
			//}
			case "investmentList":
				if($_SESSION['role'] == 2){
					$controller->investmentList();
				}else{
					$view->makeAccessDeniedPage();
				}				
				break;
			case "investing":
				if($_SESSION['role'] == 2){
					if(key_exists('projectId', $_GET)){
						if(key_exists('investing', $_POST)){
							$controller->investing($_GET['projectId'], $_POST);
						}else{
							$controller->investing($_GET['projectId']);
						}
					}
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case "validateInvestmentList":
				if($_SESSION['role'] == 2){
					$controller->validateInvestments();
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case "projectsRanking":
				if($_SESSION['role'] == 1){
					if(key_exists('projectId', $_GET)){
						$controller->projectsRankingDetails($_GET['projectId']);
					}else{
						$controller->projectsRanking();
					}
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case "exportAllInvestments":
				if($_SESSION['role'] == 1){
					$controller->exportAllInvestment();
				}else{
					$view->makeAccessDeniedPage();
				}
				break;
			
			case "parametrePageGeneral":
				if($_SESSION['role'] == 1){
					$view->makeParametrePage();
				}else{
					$view->makeAccessDeniedPage();
				}			
				break;

			case 'parametreControle':
				if($_SESSION['role'] == 1){
					$view->makeParametreControlePage();
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case 'parametreCle':
				if($_SESSION['role'] == 1){
					$controller->parametreClesPage();
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case 'createNewCles':
				if($_SESSION['role'] == 1){
					if(key_exists('create', $_POST)){
						$controller->createNewCles($_POST);
					}else{
						// $view->makeCreateNewProjectPage();
					}
				}else{
					$view->makeAccessDeniedPage();
				}
				break;

			case 'parametreRole':
				if($_SESSION['role'] == 1){
					$view->makeParametreRolePage();
				}else{
					$view->makeAccessDeniedPage();
				}
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
