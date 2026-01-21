<?php

require_once "controllers/get.controller.php";

$table = explode("?", $routesArray[1])[0]; 
$select = $_GET["select"] ?? "*";

$response = new GetController();

// **************************************************************
// Revisar petición get
// **************************************************************
if(isset($_GET["linkTo"]) && isset($_GET["equalTo"]) ){
    // Peticiones con filtros
    $response->getDataFilter($table, $select, $_GET["linkTo"], $_GET["equalTo"]);
}else{
    // Peticiones sin filtros
    $response->getData($table, $select);
}





