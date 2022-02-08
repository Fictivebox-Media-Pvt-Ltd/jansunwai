<?php
include_once '../configs/includes.php';
$category = $_POST['category'];

$query = "SELECT caste FROM tbl_voter_survey WHERE `caste_categories` = '$category' GROUP BY caste";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>