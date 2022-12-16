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
    if(!empty($_POST['start_date']) && !empty($_POST['end_date'])){
      $startDate = $_POST['start_date'];
      $endDate = $_POST['end_date'];
      $voter="SELECT  DISTINCT voter_id FROM tbl_survey WHERE surveyed_by = '$user_id' AND  created_at BETWEEN '$endDate' AND '$startDate'";
      $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
      $allTimeSurvey = mysqli_num_rows($result);

    }
else{
  $voter="SELECT  DISTINCT voter_id FROM tbl_survey WHERE surveyed_by = '$user_id'";
  $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
  $allTimeSurvey = mysqli_num_rows($result);
}

       if ($row > 0) {
          echo json_encode(array(
            "success" => true,
            "message" => "Surveyor details",
            "todaySurvey" => $row,
            "allTimeSurvey" => $allTimeSurvey), JSON_UNESCAPED_UNICODE);
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