<?php


// **************************************************************
// Depurar Errores
// **************************************************************
define('DIR',__DIR__); // Trae la ruta completa del proyecto
ini_set("display_errors", 1); 
ini_set("log_erros", 1);
ini_set("error_log", DIR."/php_error_log");

// **************************************************************
// Requerimientos
// **************************************************************
require_once "controllers/routes.controller.php";


$index = new routesController();
$index->index();
