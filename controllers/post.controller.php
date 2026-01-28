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
        
        // **********************************************************************************
        // Respuestas del controlador
        // **********************************************************************************
        $return = new PostController();
        $return->fncResponse($response);

    }



    // **************************************************************
    // Respuestas del controlador
    // **************************************************************
    public function fncResponse($response){

        if (!empty($response)) {
            $json = array(
                'status' => 200,
                'results' => $response
            );
        }else{
            $json = array(
                'status' => 404,
                'results' => 'Not Found',
                'method' => 'post'
            );
        }
        
        echo json_encode($json, http_response_code($json["status"]));
    }

}