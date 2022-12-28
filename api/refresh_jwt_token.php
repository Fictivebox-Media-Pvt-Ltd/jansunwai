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
 $user_id = $_POST['user_id'];
 $voter="SELECT username FROM tbl_admin_users WHERE id = '$user_id'";
 $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
 $row = mysqli_num_rows($result);
 if ($row > 0) {
 $row = mysqli_fetch_array($result);

 $username = $row['username'];
 $surveyed_by = $row['username'];
 $stmt = $conn->prepare("SELECT id,username, f_name, l_name,aadhar_no,phone_no,email,user_image,(select count(DISTINCT voter_id) as total_survey from tbl_survey where surveyed_by = tbl_admin_users.id), assigned_loksabha, assigned_vidhansabha FROM tbl_admin_users WHERE username = ?");
 $stmt->bind_param("s",$username);
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
$expire_at     = $date->modify('+2 minutes')->getTimestamp();      // Add 60 seconds
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
             "message" => "token updated",
             "jwt" => $jwt,
             "expireAt" => $expire_at,
             "user" => $user
          ));
 }
}
 else{

     http_response_code(401);
     echo json_encode(array( "success" => false,"message" => "failed"));
 }
//echo json_encode($response);
