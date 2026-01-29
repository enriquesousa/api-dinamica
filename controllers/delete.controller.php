<?php

require_once "models/delete.model.php";

class DeleteController
{
    // **************************************************************
    // Petición DELETE para Eliminar datos
    // **************************************************************
    public static function deleteData($table, $id, $nameId){
        
         $response = DeleteModel::deleteData($table, $id, $nameId);

        // Usa self:: para llamar a otros métodos estáticos de la misma clase
        // self::fncResponse($response); // NO ME FUNCIONA, NO SE PORQUE, pero si elimino el registro!

        $return = new DeleteController();
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
                'method' => 'delete'
            );
        }
        
        echo json_encode($json, http_response_code($json["status"]));
    }

}