<?php

require_once "models/get.model.php";

class GetController{

    // **************************************************************
    // Get data sin filtros
    // **************************************************************
    static public function getData($table, $select, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){
        
        $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
        
        $return = new GetController();
        $return -> fncResponse($response);
    }

    // **************************************************************
    // Get data con filtros
    // **************************************************************
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){

        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
        
        $return = new GetController();
        $return->fncResponse($response);
    }

    // **************************************************************
    // Peticiones GET sin filtro entre tablas relacionadas
    // **************************************************************
    static public function getRelData($rel, $type, $select, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){
        
        $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt);
        
        $return = new GetController();
        $return -> fncResponse($response);
    }

    // **************************************************************
    // Peticiones GET con filtro entre tablas relacionadas
    // **************************************************************
    static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){
        
        $response = GetModel::getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
        
        $return = new GetController();
        $return -> fncResponse($response);
    }

    // **************************************************************
    // Peticiones GET para el buscador sin relaciones
    // **************************************************************
	static public function getDataSearch($table, $select, $linkTo, $search,$orderBy,$orderMode,$startAt,$endAt){

		$response = GetModel::getDataSearch($table, $select, $linkTo, $search,$orderBy,$orderMode,$startAt,$endAt);
		
		$return = new GetController();
		$return -> fncResponse($response);
	}

    // **************************************************************
    // Peticiones GET para el buscador entre tablas relacionadas
    // **************************************************************
    static public function getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy = null, $orderMode = null, $startAt = null, $endAt = null){
        
        $response = GetModel::getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
        
        $return = new GetController();
        $return -> fncResponse($response);
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
