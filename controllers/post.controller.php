<?php

require_once "models/get.model.php";
require_once "models/post.model.php";
require_once "models/connection.php";
require_once "models/put.model.php";

require_once "vendor/autoload.php";
use Firebase\JWT\JWT;

class PostController
{
    // **************************************************************
    // Petición POST para crear datos
    // **************************************************************
    public static function postData($table, $data){
        
        $response = PostModel::postData($table, $data);
        
        $return = new PostController();
        $return->fncResponse($response, null, null);

    }

    // **************************************************************
    // Petición POST para Registrar usuario
    // **************************************************************
    public static function postRegister($table, $data, $suffix){
        
        if( isset($data["password_".$suffix]) && $data["password_".$suffix] != null ){
            
            // Cadena de texto alfanumérico que genere de 40 caracteres: zvyN70EpB1PhNKTiQdDvnmugEw7c80NXzp539JQr
            // Para poder usar el BLOWFISH tenemos que insertar el $2a$07$ ... $ en la cadena
            $crypt = crypt($data["password_".$suffix], '$2a$07$zvyN70EpB1PhNKTiQdDvnmugEw7c80NXzp539JQr$');
            $data["password_".$suffix] = $crypt;

            $response = PostModel::postData($table, $data);
            
            $return = new PostController();
            $return->fncResponse($response, null, $suffix);

        }else{

            // ******************************************************************************
            // Registro de usuario desde aplicaciones externas, como google, facebook etc ...
            // ******************************************************************************
            $response = PostModel::postData($table, $data);
            if( isset($response["comment"]) && $response["comment"] == "The process was successful" ){

                // **************************************************************
                // Validar que el ID si exista!
                // **************************************************************
                $response = GetModel::getDataFilter($table, "*", "email_".$suffix, $data["email_".$suffix], null, null, null, null);
                if( !empty($response) ){
                    
                    $token = Connection::jwt($response[0]->{ "id_".$suffix }, $response[0]->{ "email_".$suffix });
                    $jwt = JWT::encode($token, "w68pBZa0wZfiYgAXrmhsuNLIR5De67rKxiTEEipN", 'HS256');
    
                    // **************************************************************
                    // Actualizamos la base de datos con el token del usuario
                    // **************************************************************
                    $data = array(
                        "token_".$suffix => $jwt,
                        "token_exp_".$suffix => $token["exp"]
                    );
                    
                    $update = PutModel::putData($table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
    
                    if(isset($update["comment"]) && $update["comment"] == "The process was successful" ){
    
                        $response[0]->{"token_".$suffix} = $jwt;
                        $response[0]->{"token_exp_".$suffix} = $token["exp"];
    
                        $return = new PostController();
                        $return -> fncResponse($response, null, $suffix);
                    }

                }


            }

        }
        
    }

    // **************************************************************
    // Petición POST para Login de usuario
    // **************************************************************
    public static function postLogin($table, $data, $suffix){
        
        // **************************************************************
        // Validar que el ID si exista!
        // **************************************************************
        $response = GetModel::getDataFilter($table, "*", "email_".$suffix, $data["email_".$suffix], null, null, null, null);

        if( !empty($response) ){
            
            if( $response[0]->{ "password_".$suffix } != null ){
                
                // **************************************************************
                // Validar el password
                // **************************************************************
                $crypt = crypt( $data["password_".$suffix], '$2a$07$zvyN70EpB1PhNKTiQdDvnmugEw7c80NXzp539JQr$');
                if( $response[0]->{ "password_".$suffix } == $crypt ) {
    
                    // $return = new PostController();
                    // $return->fncResponse($response);
    
                    // **************************************************************
                    // Vamos a crear el token de seguridad
                    // **************************************************************
                    $token = Connection::jwt($response[0]->{ "id_".$suffix }, $response[0]->{ "email_".$suffix });
                    $jwt = JWT::encode($token, "w68pBZa0wZfiYgAXrmhsuNLIR5De67rKxiTEEipN", 'HS256');
    
                    // **************************************************************
                    // Actualizamos la base de datos con el token del usuario
                    // **************************************************************
                    $data = array(
                        "token_".$suffix => $jwt,
                        "token_exp_".$suffix => $token["exp"]
                    );
                    
                    $update = PutModel::putData($table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
    
                    if(isset($update["comment"]) && $update["comment"] == "The process was successful" ){
    
                        $response[0]->{"token_".$suffix} = $jwt;
                        $response[0]->{"token_exp_".$suffix} = $token["exp"];
    
                        $return = new PostController();
                        $return -> fncResponse($response, null, $suffix);
                    }
    
    
                }else{
    
                    $response = null;
                    $return = new PostController();
                    $return->fncResponse($response, "Wrong Password", $suffix);
                    
                }

            }else{

                // *******************************************************************************
                // Significa que el usuario se pudo haber registrado con redes sociales
                // Creamos el token de seguridad para el usuario que fue logueado con app externa
                // *******************************************************************************

                $token = Connection::jwt($response[0]->{ "id_".$suffix }, $response[0]->{ "email_".$suffix });
                $jwt = JWT::encode($token, "w68pBZa0wZfiYgAXrmhsuNLIR5De67rKxiTEEipN", 'HS256');

                // **************************************************************
                // Actualizamos la base de datos con el token del usuario
                // **************************************************************
                $data = array(
                    "token_".$suffix => $jwt,
                    "token_exp_".$suffix => $token["exp"]
                );
                
                $update = PutModel::putData($table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);

                if(isset($update["comment"]) && $update["comment"] == "The process was successful" ){

                    $response[0]->{"token_".$suffix} = $jwt;
                    $response[0]->{"token_exp_".$suffix} = $token["exp"];

                    $return = new PostController();
                    $return -> fncResponse($response, null, $suffix);
                }

            }


        }else{

            $response = null;
            $return = new PostController();
            $return->fncResponse($response, "Wrong Email", $suffix);

        }
        
    }



    // **************************************************************
    // Respuestas del controlador
    // **************************************************************
    public function fncResponse($response, $error = null, $suffix = null){

        /*=============================================
        Quitamos la contraseña de la respuesta
        =============================================*/
        if(isset($response[0]->{"password_".$suffix})){
            unset($response[0]->{"password_".$suffix});
        }

        if (!empty($response)) {

            $json = array(
                'status' => 200,
                'results' => $response
            );

        }else{

            if($error != null){

                $json = array(
                    'status' => 400,
                    'results' => $error
                );

            }else{

                $json = array(
                    'status' => 404,
                    'results' => 'Not Found',
                    'method' => 'post'
                );

            }

        }
        
        echo json_encode($json, http_response_code($json["status"]));
    }

}