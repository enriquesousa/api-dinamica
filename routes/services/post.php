<?php

require_once "models/connection.php";
require_once "controllers/post.controller.php";

if( isset($_POST) ){

    // **************************************************************
    // Separar propiedades en un arreglo
    // **************************************************************
    $columns = array();
    foreach (array_keys($_POST) as $key => $value) {
        array_push($columns, $value);
    }

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
    // Petición POST 
    // **********************************************************************************
    $response = new PostController();

    if( isset($_GET["register"]) && $_GET["register"] == "true" ){

        // **********************************************************************************
        // Petición POST para el registro de usuarios
        // **********************************************************************************

        $suffix = $_GET["suffix"] ?? "user";
        $response->postRegister($table, $_POST, $suffix);

    }else if( isset($_GET["login"]) && $_GET["login"] == "true" ){

        // **********************************************************************************
        // Petición POST para login de usuario
        // **********************************************************************************

        $suffix = $_GET["suffix"] ?? "user";
        $response->postLogin($table, $_POST, $suffix);

    }
    else{

        // **********************************************************************************
        // Solicitamos respuesta del controlador para crear datos en cualquiera de las tablas
        // **********************************************************************************
        
        $response->postData($table, $_POST);

    }





}