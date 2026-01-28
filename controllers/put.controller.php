<?php

require_once "models/put.model.php";

class PutController
{
    // **************************************************************
    // Petición PUT para editar datos
    // **************************************************************
    public static function putData($table, $data, $id, $nameId){

        // **********************************************************************************
        // Solicitamos respuesta del modelo
        // **********************************************************************************
        $response = PutModel::putData($table, $data, $id, $nameId);
        // echo '<pre>'; print_r($response); echo '</pre>';
        // return;
        
        // **********************************************************************************
        // Respuestas del controlador
        // **********************************************************************************
        $return = new PutController();
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
                'method' => 'put'
            );
        }
        
        echo json_encode($json, http_response_code($json["status"]));
    }

}