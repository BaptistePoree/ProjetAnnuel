<?php


class RoleStorage
{

    public function __construct(View $view = null)
    {
        $this->view = $view;
    }

    public function isInvestisementOuvert(){
        try{
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT insvestire FROM role WHERE id = 2 AND insvestire = 1";
            $stmt = $bd->prepare($rq);
            $data = array();
            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (sizeof($result) === 1);
        }catch(PDOException $e){
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }    
    
    public function convertionInsvestire($num = 0, $role = 2)
    {
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $rq = "UPDATE role SET insvestire = $num WHERE id = :idRole";
        $stmt = $bd->prepare($rq);
        $data = array(":idRole" => $role);
        try {
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($stmt->execute($data)) {
                return true;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }


}
