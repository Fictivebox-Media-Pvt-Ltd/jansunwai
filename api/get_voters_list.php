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
        if(empty($_POST['mandal'])){
            echo json_encode(array(
                "message" => "mandal field is required."
                ));
                exit();
        }
        if(empty($_POST['panchayat'])){
            echo json_encode(array(
                "message" => "panchayat field is required."
                ));
                exit();
        }
        if(empty($_POST['booth_no'])){
            echo json_encode(array(
                "message" => "booth number field is required."
                ));
                exit();
        }

        if ($_POST['loksabha'] != '' && $_POST['vidhansabha'] != '' && $_POST['booth_no'] != '') {
            $vidhansabha = $_POST['vidhansabha'];
            $booth_no = $_POST['booth_no'];
            $voter_name_hin = isset($_POST['name']) ? $_POST['name'] : ''; // Optional
            $house_no = isset($_POST['house_no']) ? $_POST['house_no'] : '0'; // Optional
        }


        $voterIdsThatHasBeenSurveyed = array();
        $queryForVoterIds = "SELECT * FROM (SELECT voter_id FROM `tbl_mumbai_voter_survey` UNION SELECT voter_id FROM `tbl_voter_survey`) as voter_ids";
        $queryForVoterIdsResult = mysqli_query($conn, $queryForVoterIds);
        $voterIds = mysqli_fetch_all($queryForVoterIdsResult);
        foreach ($voterIds as $key => $value) {
            $voterIdsThatHasBeenSurveyed[] = $value[0];
        }

        $query = "SELECT * FROM `tbl_voters` WHERE id NOT IN (" . implode(", ", $voterIdsThatHasBeenSurveyed) . ") AND `vidhansabha` = '$vidhansabha' AND `booth_no` = '$booth_no'";

        if ($house_no != '0' && $house_no != 0 && $house_no != 'मकान सं चुने') {
            $query .= "AND `house_no` = '$house_no'";
        }

        if ($voter_name_hin != '' && $voter_name_hin != 'वोटर का नाम') {
            $query .= "AND `voter_name_hin` LIKE '%$voter_name_hin%'";
        }

        mysqli_set_charset($conn, 'utf8');
        $result = mysqli_query($conn, $query) or die("Query problem" . mysqli_error($conn));
        $rows = mysqli_num_rows($result);

        $i = 0;
        if ($rows > 0) {
            $info = array();
            while ($row = mysqli_fetch_array($result)){
                $i++;
                array_push($info, array(
                    'id' => $row['id'], 'house_no' => $row['house_no'], 'name' => $row['voter_name_hin'], 'age' => $row['voter_age'], 'address' => $row['poling_station_hin'], 'father_husband_name' => $row['father_husband_name_hin'],'survey_status' => true
                ));
            }
            echo json_encode(array(
                "success" => true,
	            "message" => "voters List",
                "voters_list" => $info), JSON_UNESCAPED_UNICODE);
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
