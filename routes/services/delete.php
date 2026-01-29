<?php

require_once "models/connection.php";
require_once "controllers/delete.controller.php";

if( isset($_GET["id"]) && isset($_GET["nameId"]) ){

    
    $columns = array($_GET["nameId"]);

    // **************************************************************
    // Validar existencia de la tabla y de las columnas
    // **************************************************************
    if( empty(Connection::getColumnsData($table, $columns)) ){ 
        $json = array(
            'status' => 400,
            'result' => 'Error: Fields in the form do not match the database table'
        );
        echo json_encode($json, http_response_code($json["status"])); // Respuestas del controlador
        return;
    }


    // *************************************************************************************
    // Solicitamos respuesta del controlador para Eliminar datos en cualquiera de las tablas
    // *************************************************************************************
    $response = new DeleteController();
    $response->deleteData($table, $_GET["id"], $_GET["nameId"]);

}