<?php
require_once("config.php");
require_once("Router.php");
session_start();
//Pour les test en attendant crétaion la table des utilisateur on défini un id temporaire, ici 1
$_SESSION['userId'] = 1;
$router = new Router();
$router->main();
?>