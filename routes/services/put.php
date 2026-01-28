<?php

require_once "models/connection.php";
require_once "controllers/put.controller.php";

if( isset($_GET["id"]) && isset($_GET["nameId"]) ){

    // **************************************************************
    // Capturar los datos del formulario
    // **************************************************************
    $data = array();
    parse_str(file_get_contents('php://input'), $data);

    // **************************************************************
    // Separar propiedades en un arreglo
    // **************************************************************
    $columns = array();
    foreach (array_keys($data) as $key => $value) {
        array_push($columns, $value);
    }
    array_push($columns, $_GET["nameId"]);
    $columns = array_unique($columns);

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



    // **********************************************************************************
    // Solicitamos respuesta del controlador para editar datos en cualquiera de las tablas
    // **********************************************************************************
    $response = new PutController();
    $response->putData($table, $data, $_GET["id"], $_GET["nameId"]);

}