<?php

require_once("model/Cles.php");

class ClesStorage
{

    public function __construct(View $view = null)
    {
        $this->view = $view;
    }

    public function addCles($cles)
    {
        try {
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "INSERT INTO cles (idRole, cles)  VALUES (:idRole, :cles)";
            $stmt = $bd->prepare($rq);
            $data = array(
                ":idRole" => $cles->getRole(),
                ":cles" => $cles->getCles()
            );
            if ($stmt->execute($data)) {
                return $bd->lastInsertId();
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        } catch (Exception $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getListeClesRole()
    {
        try {

            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT role.nomRole, cles.idRole, cles.id, cles.cles, cles.isValider FROM cles, role  WHERE role.id = cles.idRole";
            $stmt = $bd->query($rq);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result != null) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function estUnique($cle)
    {
        $rq = $this->getCle($cle);
        return $rq->rowCount() == 0;
    }

    public function isValide($cle)
    {
        $rq = $this->getCle($cle);
        $result = $rq->fetch();
        if ($result) {
            var_dump($result);
            return !$result["isValider"];
        }
        return false;
    }

    public function setValid($cle)
    {
        try {
            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = $bd->prepare("UPDATE cles SET isValider = ? WHERE cles = ?");
            $rq->execute(array(true, $cle));
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }

    public function getRoleByCle($cle)
    {
        $rq = $this->getCle($cle);
        $result = $rq->fetch();
        var_dump($result);
        return $result["idRole"];
    }

    public function getCle($cle)
    {
        $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $rq = $bd->prepare("SELECT * FROM cles WHERE cles = ?");
        $rq->execute(array($cle));
        return $rq;
    }

    public function getListeCles()
    {
        try {

            $bd = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $rq = "SELECT cles.cles FROM cles";
            $stmt = $bd->query($rq);

            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if ($result != null) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->view->makeErrorPage('Erreur lors d\'une requête à la base de donnée', $e->getMessage());
            return 'error';
        }
    }
}
