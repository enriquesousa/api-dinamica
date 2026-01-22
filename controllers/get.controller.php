<?php

require_once "models/get.model.php";

class GetController{

    // **************************************************************
    // Get data sin filtros
    // **************************************************************
    static public function getData($table, $select){   
        $response = GetModel::getData($table, $select);
        
        $return = new GetController();
        $return -> fncResponse($response);
    }

    // **************************************************************
    // Get data con filtros
    // **************************************************************
    static public function getDataFilter($table, $select, $linkTo, $equalTo){   

        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo);
        
        $return = new GetController();
        $return->fncResponse($response);
    }

    // **************************************************************
    // Respuestas del controlador
    // **************************************************************
    public function fncResponse($response){

        if (!empty($response)) {
            $json = array(
                'status' => 200,
                'total' => count($response),
                'results' => $response
            );
        }else{
            $json = array(
                'status' => 404,
                'results' => 'Not Found'
            );
        }
        
        echo json_encode($json, http_response_code($json["status"]));
    }


}
