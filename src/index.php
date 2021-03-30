<?php
require_once("config.php");
require_once("Router.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$router = new Router();
$router->main();
?>