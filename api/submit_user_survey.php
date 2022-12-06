<?php
include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($jwt){ 
			try {
			$decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));
      $payload = (array) json_decode(file_get_contents('php://input'),TRUE);
      $survey_question = $payload['survey_question'];
      $voter_id = $payload['voter_id'];
      $surveyed_by = $payload['user_id'];
      $questioncount = count($survey_question);

			if(empty($surveyed_by)){
				echo json_encode(array(
					"message" => "user_id field is required."
					));
					exit();
			}
      if(empty($voter_id)){
				echo json_encode(array(
					"message" => "voter Id field is required."
					));
					exit();
			}
        for ($x = 0; $x < $questioncount; $x++){
          $question_id = $survey_question[$x]['question_id'];
          $selected_options = implode(", ", $survey_question[$x]["selected_options"]);
          $query = "INSERT INTO tbl_survey(voter_id,question_id,selected_options,created_at,surveyed_by) VALUES ('$voter_id','$question_id','$selected_options', now(),'$surveyed_by')";
        // print_r($query);
          mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
        }
        echo json_encode(array("success" => true,
        "message" => "survey submitted successfully"),JSON_UNESCAPED_UNICODE);
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