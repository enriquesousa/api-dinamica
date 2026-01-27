<?php

require_once "models/post.model.php";

class PostModel
{

    // **************************************************************
    // Petición POST para crear datos de forma dinámica
    // **************************************************************
    public static function postData($table, $data){

        echo '<pre>'; print_r($table); echo '</pre>';
        echo '<pre>'; print_r($data); echo '</pre>';
        return;

    }



}
