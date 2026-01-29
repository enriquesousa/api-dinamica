<?php

require_once "models/get.model.php";
require_once "models/post.model.php";

class PostController
{
    // **************************************************************
    // Petición POST para crear datos
    // **************************************************************
    public static function postData($table, $data){
        
        $response = PostModel::postData($table, $data);
        
        $return = new PostController();
        $return->fncResponse($response, null);

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
            $return->fncResponse($response, null);

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
            
            // **************************************************************
            // Validar el password
            // **************************************************************
            $crypt = crypt( $data["password_".$suffix], '$2a$07$zvyN70EpB1PhNKTiQdDvnmugEw7c80NXzp539JQr$');
            if( $response[0]->{ "password_".$suffix } == $crypt )
            {

                $return = new PostController();
                $return->fncResponse($response);

                // **************************************************************
                // Vamos a crear el token de seguridad
                // **************************************************************

                


            }else{

                $response = null;
                $return = new PostController();
                $return->fncResponse($response, "Wrong Password");
                
            }

        }else{

            $response = null;
            $return = new PostController();
            $return->fncResponse($response, "Wrong Email");

        }

        
        
    }



    // **************************************************************
    // Respuestas del controlador
    // **************************************************************
    public function fncResponse($response, $error = null){

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