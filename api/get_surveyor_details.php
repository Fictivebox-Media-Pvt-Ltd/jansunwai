<?php
include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($jwt){ 
			try {
			$decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));

    if(empty($_POST['user_id'])){
        echo json_encode(array(
            "message" => "user_id field is required."
            ));
            exit();
    }
    $todaydate = date('Y-m-d',strtotime("-1 days"));
      $user_id = $_POST['user_id'];
      $voter="SELECT  DISTINCT voter_id FROM tbl_survey WHERE surveyed_by = '$user_id' AND created_at >'$todaydate'";
      $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
      $row = mysqli_num_rows($result);
if(isset($_POST['start_date']) && isset($_POST['end_date'])){

print_r("deepak");
die;
}


     
      $voter="SELECT  DISTINCT voter_id FROM tbl_survey WHERE surveyed_by = '$user_id' AND created_at >'$todaydate'";
      $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
      $row = mysqli_num_rows($result);

       if ($row > 0) {
          echo json_encode(array(
            "success" => true,
            "message" => "Surveyor details",
            "today_survey" => $row,
            "user_profile" => $personal_details), JSON_UNESCAPED_UNICODE);
      }
      else{
        
        echo json_encode(array(
          "success" => true,
          "message" => "Data Not Found"), JSON_UNESCAPED_UNICODE);
      }
      }
      catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
        "success" => false,
        "message" => "Access denied.",
        "error" => $e->getMessage()
        ));
      }
  }
?>