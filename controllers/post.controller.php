<?php

require_once "models/post.model.php";

class PostController
{
    // **************************************************************
    // Petición POST para crear datos
    // **************************************************************
    public static function postData($table, $data){

        // **********************************************************************************
        // Solicitamos respuesta del modelo
        // **********************************************************************************
        $response = PostModel::postData($table, $data);
        echo '<pre>'; print_r($response); echo '</pre>';
        return;


    }


}