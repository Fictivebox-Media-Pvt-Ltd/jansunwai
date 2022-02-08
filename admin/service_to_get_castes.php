<?php
include_once '../configs/includes.php';
$location_id = $_POST['location_id'];
$query = "SELECT id, voters_caste FROM `google_map_stats` WHERE `map_id` = $location_id";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>