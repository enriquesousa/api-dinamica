<?php

require_once "connection.php";
require_once "get.model.php";

class DeleteModel
{

    // **************************************************************
    // Petición DELETE para Eliminar datos de forma dinámica
    // **************************************************************
    public static function deleteData($table, $id, $nameId){

        // **************************************************************
        // Validar que el ID si exista!
        // **************************************************************
        $response = GetModel::getDataFilter($table, $nameId, $nameId, $id, null, null, null, null);
        if(empty($response)){
            return null;
        }

        // **************************************************************
        // Eliminar el registro de la base de datos
        // **************************************************************
        $sql = "DELETE FROM $table WHERE $nameId = :$nameId";

        $link = Connection::connect();
        $stmt = $link->prepare($sql);

        $stmt->bindParam(":".$nameId, $id, PDO::PARAM_STR);

        if( $stmt->execute() ){
            $response = array(
                "comment" => "The process was successful"
            );
            return $response;
        }else{
            return $link->errorInfo();
        }

    }



}
