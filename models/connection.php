<?php

require_once "get.model.php";

class Connection{
    
    /*=============================================
	Información de la base de datos
	=============================================*/
	static public function infoDatabase(){
		$infoDB = array(
			"database" => "database-1",
			"user" => "root",
			"pass" => ""
		);
		return $infoDB;
	}

    /*=============================================
	Conexión a la base de datos
	=============================================*/
	static public function connect(){

		try{
			$link = new PDO(
				"mysql:host=localhost;dbname=".Connection::infoDatabase()["database"],
				Connection::infoDatabase()["user"], 
				Connection::infoDatabase()["pass"]
			);
			$link->exec("set names utf8");
		}catch(PDOException $e){
			die("Error: ".$e->getMessage());
		}
        
		return $link;
	}

    // ****************************************************************
    // Validar existencia una tabla en la base de datos y sus columnas
    // ****************************************************************
    static public function getColumnsData($table, $columns){

        /*=============================================
		Traer el nombre de la base de datos
		=============================================*/
		$database = Connection::infoDatabase()["database"];

		/*=============================================
		Traer todas las columnas de una tabla
		=============================================*/
		$validate = Connection::connect()
		->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
		->fetchAll(PDO::FETCH_OBJ);

		/*=============================================
		Validamos existencia de la tabla
		=============================================*/
		if(empty($validate)){
			return null;
		}else{

			/*========================================================================
			Ajuste de selección de columnas globales - Traer el nombre de las columnas
			==========================================================================*/
			if($columns[0] == "*"){
				array_shift($columns);
			}

			/*=============================================
			Validamos existencia de columnas
			=============================================*/
			$sum = 0;
			foreach ($validate as $key => $value) {
				$sum += in_array($value->item, $columns);
			}

			return $sum == count($columns) ? $validate : null;
		}

    }

    // ****************************************************************
    // Generar Token de Autenticación
    // ****************************************************************
    static public function jwt($id, $email){

        $time = time(); // Tiempo en que inicia el token - current time

		$token = array(
			"iat" =>  $time, 
			"exp" => $time + (60*60*24), // Tiempo en que expirará el token (1 día) - segundos * minutos * horas
			"data" => [
				"id" => $id,
				"email" => $email
			]
		);

        // $jwt = JWT::encode($token, "w68pBZa0wZfiYgAXrmhsuNLIR5De67rKxiTEEipN", 'HS256');
        // echo '<pre>'; print_r($jwt); echo '</pre>';

		return $token;
    }

    // ****************************************************************
    // Validar el token de seguridad
    // ****************************************************************
    // static public function tokenValidate($token,$table,$suffix){

	// 	/*=============================================
	// 	Traemos el usuario de acuerdo al token
	// 	=============================================*/
	// 	$user = GetModel::getDataFilter($table, "token_exp_".$suffix, "token_".$suffix, $token, null,null,null,null);
		
	// 	if(!empty($user)){

	// 		/*=============================================
	// 		Validamos que el token no haya expirado
	// 		=============================================*/	
	// 		$time = time();

	// 		if($time < $user[0]->{"token_exp_".$suffix}){
	// 			return "ok";
	// 		}else{
	// 			return "expired";
	// 		}

	// 	}else{
	// 		return "no-auth";
	// 	}

	// }
    static public function tokenValidate($token, $table, $suffix){

    	/*=============================================
		Traemos el usuario de acuerdo al token
		=============================================*/
		$user = GetModel::getDataFilter($table, "*", "token_".$suffix, $token, null,null,null,null);

        if(!empty($user)){

            /*=============================================
            Validamos que el token no haya expirado
            =============================================*/


        }

    }


}