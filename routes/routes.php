<?php

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);

// **************************************************************
// Cuando no se hace ninguna petición a la API
// **************************************************************
if(count($routesArray) == 0){
	$json = array(
		'status' => 404,
		'results' => 'Not Found'
	);
	echo json_encode($json, http_response_code($json["status"]));
	return;
}

// **************************************************************
// Cuando si se hace una petición a la API
// **************************************************************
if(count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD'])){

    // echo '<pre>'; print_r($_SERVER['REQUEST_METHOD']); echo '</pre>';
 
    $table = explode("?", $routesArray[1])[0]; 

	/*=============================================
	Validar llave secreta
	=============================================*/
	// if(!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != Connection::apikey()){
	// 	if(in_array($table, Connection::publicAccess()) == 0){
	// 		$json = array(
	// 			'status' => 400,
	// 			"results" => "You are not authorized to make this request"
	// 		);
	// 		echo json_encode($json, http_response_code($json["status"]));
	// 		return;
	// 	}else{
	// 		/*=============================================
	// 		Acceso público
	// 		=============================================*/
	// 		$response = new GetController();
	// 		$response -> getData($table, "*",null,null,null,null);
	// 		return;
	// 	}
	// }

	/*=============================================
	Peticiones GET
	=============================================*/
	if($_SERVER['REQUEST_METHOD'] == "GET"){
		include "services/get.php";
	}

	/*=============================================
	Peticiones POST
	=============================================*/
	if($_SERVER['REQUEST_METHOD'] == "POST"){
        // $json = array(
        //     'status' => 200,
        //     'result' => 'Solicitud POST'
        // );
        // echo json_encode($json);
		include "services/post.php";
	}

	/*=============================================
	Peticiones PUT
	=============================================*/
	if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $json = array(
            'status' => 200,
            'result' => 'Solicitud PUT'
        );
        echo json_encode($json);
		// include "services/put.php";
	}

	/*=============================================
	Peticiones DELETE
	=============================================*/
	if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $json = array(
            'status' => 200,
            'result' => 'Solicitud DELETE'
        );
        echo json_encode($json);
		// include "services/delete.php";
	}

    return;

}