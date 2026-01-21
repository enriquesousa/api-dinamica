<?php

require_once "connection.php";

class GetModel {
    
    // **************************************************************
    // Get data sin filtros
    // **************************************************************
    static public function getData($table, $select){

        $sql = "SELECT $select FROM $table";
        $stmt = Connection::connect()->prepare($sql);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;

    }

    // **************************************************************
    // Get data con filtros
    // **************************************************************
    static public function getDataFilter($table, $select, $linkTo, $equalTo){

        $sql = "SELECT $select FROM $table WHERE $linkTo = :$linkTo"; // para la seguridad usar bindParam de PDO
        $stmt = Connection::connect()->prepare($sql);
        $stmt->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;
        
    }

}