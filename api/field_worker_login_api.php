<?php 
include_once '../configs/database.php';
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 $response = array();
 $username = $_POST['username'];
 $surveyed_by = $_POST['username'];
 $password = md5($_POST['password']); 

 
 $stmt = $conn->prepare("SELECT id,username, f_name, l_name,aadhar_no,phone_no,email,user_image,(select sum(data.total_survey) as total_survey from ( select count(*) as total_survey from tbl_voter_survey where surveyed_by = ? UNION ALL select count(*) as total_survey from tbl_mumbai_voter_survey where surveyed_by = ? ) data), assigned_loksabha, assigned_vidhansabha FROM tbl_admin_users WHERE username = ? AND password = ?");
 $stmt->bind_param("ssss",$surveyed_by,$surveyed_by,$username, $password);
 
 $stmt->execute();
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 
 $stmt->bind_result($id, $username, $f_name,$l_name,$aadhar,$phone,$email,$user_image,$total_survey,$assigned_loksabha,$assigned_vidhansabha);
 $stmt->fetch();
 $user = array(
 'id'=>$id, 
 'username'=>$username, 
 'name'=>$f_name." ".$l_name, 
 'aadhar_no'=>$aadhar,
 'phone_no'=>$phone,
 'email'=>$email,
 'user_image'=>$user_image,
 'total_survey'=>$total_survey,
 'assigned_loksabha'=>$assigned_loksabha,
 'assigned_vidhansabha'=>$assigned_vidhansabha
 );

$secret_Key  = '68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=';
$date   = new DateTimeImmutable();
$expire_at     = $date->modify('+2880 minutes')->getTimestamp();      // Add 60 seconds
$domainName = "https://surveyapp.fictivebox.com";                  // Retrieved from filtered POST data
$request_data = [
    'iat'  => $date->getTimestamp(),         // Issued at: time when the token was generated
    'iss'  => $domainName,                       // Issuer
    'nbf'  => $date->getTimestamp(),         // Not before
    'exp'  => $expire_at,                           // Expire
    'data' => [
        'uid' => $id,
        'name' => $username,
        'email' => $email]
    ];

     http_response_code(200);
     $jwt = JWT::encode($request_data,$secret_Key,'HS256');
 echo json_encode(
         array(
            "success" => true,
             "message" => "Login successfull",
             "jwt" => $jwt,
             "expireAt" => $expire_at,
             "user" => $user
          ));
 }
 else{

     http_response_code(401);
     echo json_encode(array( "success" => false,"message" => "Login failed."));
 }
//echo json_encode($response);
