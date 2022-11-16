<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$secret_key ='68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=';
$jwt = null;
$headers = getallheaders();   
if(empty($headers['Authorization'])){
    echo json_encode(array(
        "success" => false,
        "message" => "Access denied."
        ));
        exit();
}
$authHeader = $headers['Authorization'];
$jwt = str_replace('Bearer ', '', $authHeader);

?>