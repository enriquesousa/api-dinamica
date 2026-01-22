<?php

require_once "connection.php";

class GetModel {
    
    // **************************************************************
    // Get data sin filtros
    // **************************************************************
    static public function getData($table, $select, $orderBy = null, $orderMode = null){

        // $sql = "SELECT $select FROM $table";
        if($orderBy != null && $orderMode != null){
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        $stmt = Connection::connect()->prepare($sql);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;

    }

    // **************************************************************
    // Get data con filtros
    // **************************************************************
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy = null, $orderMode = null){

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode("_", $equalTo);
        $linkToText = "";

        if(count($linkToArray)>1){
			foreach ($linkToArray as $key => $value) {
				if($key > 0){
					$linkToText .= "AND ".$value." = :".$value." ";
				}
			}
		}

        // Preparar la consulta sql 
        // $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText"; 
        if($orderBy != null && $orderMode != null){
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }


        $stmt = Connection::connect()->prepare($sql);

        // Para la seguridad usar bindParam de PDO
        foreach ($linkToArray as $key => $value) {
			$stmt -> bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);
		}
        $stmt->execute();

        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }

}