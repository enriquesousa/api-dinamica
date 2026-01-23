<?php

require_once "controllers/get.controller.php";

$table = explode("?", $routesArray[1])[0]; 
$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$orderMode = $_GET["orderMode"] ?? null;
$startAt = $_GET["startAt"] ?? null;
$endAt = $_GET["endAt"] ?? null;

$response = new GetController();

// **************************************************************
// Revisar petición get
// **************************************************************
if( isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && !isset($_GET["rel"]) && !isset($_GET["type"]) ){

    // Peticiones con filtros
    $response->getDataFilter($table, $select, $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode, $startAt, $endAt);

}else if( isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])){
 
    // Peticiones GET sin filtro entre tablas relacionadas
    $response->getRelData($_GET["rel"], $_GET["type"], $select, $orderBy, $orderMode, $startAt, $endAt);

}else if( isset($_GET["rel"]) && isset($_GET["type"]) && $table == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"])){
 
    // Peticiones GET con filtro entre tablas relacionadas
    $response->getRelDataFilter($_GET["rel"], $_GET["type"], $select, $_GET["linkTo"], $_GET["equalTo"],$orderBy, $orderMode, $startAt, $endAt);

}else if( !isset($_GET["rel"]) && !isset($_GET["type"]) && isset($_GET["linkTo"]) && isset($_GET["search"]) ){

    // Peticiones para el buscador sin relaciones
    $response->getDataSearch($table, $select, $_GET["linkTo"], $_GET["search"], $orderBy, $orderMode, $startAt, $endAt);

}else{

    // Peticiones sin filtros
    $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);

}





