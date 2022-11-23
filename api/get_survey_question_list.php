<?php
include_once '../configs/database.php';
set_time_limit(300);
error_reporting(0);
ini_set('display_errors', '0');
date_default_timezone_set("Asia/Calcutta");

require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\Key;

if ($jwt) {
    try {
        if(empty($_POST['user_id'])){
            echo json_encode(array(
                "message" => "user_id field is required."
                ));
                exit();
        }
        if(empty($_POST['loksabha'])){
            echo json_encode(array(
                "message" => "loksabha field is required."
                ));
                exit();
        }
        if(empty($_POST['vidhansabha'])){
            echo json_encode(array(
                "message" => "vidhansabha field is required."
                ));
                exit();
        }

        $loksabha = $_POST['loksabha'];
        $vidhansabha = $_POST['vidhansabha'];
        $query = "SELECT id,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 FROM `tbl_survey_questions` WHERE `vidhansabha` = '$vidhansabha' AND `loksabha` = '$loksabha'";

        mysqli_set_charset($conn, 'utf8');
        $result = mysqli_query($conn, $query) or die("Query problem" . mysqli_error($conn));
        $rows = mysqli_num_rows($result);

        $i = 0;
        if ($rows > 0) {
            $info = array();
            while ($row = mysqli_fetch_array($result)){
                $i++;
                array_push($info, array(
                    'id' => $row['id'], 'question' => $row['question'], 'option1' => $row['option1'], 'option2' => $row['option2'], 'option3' => $row['option3'], 'option4' => $row['option4'],'option5' => $row['option5'],'option6' => $row['option6'],'option7' => $row['option7'],'option8' => $row['option8'],'option9' => $row['option9'],'option10' => $row['option10']));
            }
            echo json_encode(array(
                "success" => true,
	            "message" => "question List",
                "question_list" => $info), JSON_UNESCAPED_UNICODE);
        }else {
                echo json_encode(array("success" => true,
                "message" => "No data found"),JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "success" => false,
            "message" => "Access denied.",
            "error" => $e->getMessage(),
        ));
    }
}
