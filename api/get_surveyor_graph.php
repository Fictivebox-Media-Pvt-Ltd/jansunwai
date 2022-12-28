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
      $graphQuery = "SELECT date_format(created_at,'%H %p') as hour,count(voter_id) as totalsurvey FROM tbl_survey group by date_format(created_at,'%H %p')";
      //$voter="SELECT  DISTINCT voter_id FROM tbl_survey WHERE surveyed_by = '$user_id' ";
      $graphresult=mysqli_query($conn,$graphQuery) or die("Query problem".mysqli_error($conn));
      $row = mysqli_fetch_array($graphresult);
      print_r($row);
      die;

      $info = array();
      while ($row = mysqli_fetch_array($graphresult)){
          $i++;
          array_push($info, array(
              'id' => $row['id'], 'question' => $row['question'], 'option1' => $row['option1'], 'option2' => $row['option2'], 'option3' => $row['option3'], 'option4' => $row['option4'],'option5' => $row['option5'],'option6' => $row['option6'],'option7' => $row['option7'],'option8' => $row['option8'],'option9' => $row['option9'],'option10' => $row['option10']));
      }


      if ($allTimeSurvey > 0 || $row > 0) {
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