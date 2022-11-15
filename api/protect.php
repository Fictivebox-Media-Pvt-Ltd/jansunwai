<?php

include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    if($jwt){
        try {
            $decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));
            

            // Access is granted. Add code of the operation here 

            echo json_encode(array(
                "message" => "Access granted:",
            ));

        }
        catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
        }

    }
?>