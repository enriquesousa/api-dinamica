<?php

require_once "connection.php";

class GetModel {
    
    // **************************************************************
    // Get data sin filtros
    // **************************************************************
    static public function getData($table, $select, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){

        // Sin filtrar y sin ordenar datos 
        $sql = "SELECT $select FROM $table";

        // Estamos Ordenando sin limitar datos
        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        // Ordenar y limitar Datos
        if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
        }

        // Solo limitar Datos sin ordenar
        if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
            $sql = "SELECT $select FROM $table LIMIT $startAt, $endAt";
        }

        $stmt = Connection::connect()->prepare($sql);
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;

    }

    // **************************************************************
    // Get data con filtros
    // **************************************************************
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){

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
        // Sin filtrar y sin ordenar datos 
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText"; 
 
        // Estamos Ordenando sin limitar datos
        if($orderBy != null && $orderMode != null){
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }

        // Ordenar y limitar Datos
        if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
        }

        // Solo limitar Datos sin ordenar
        if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt";
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