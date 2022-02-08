<?php
include_once '../configs/includes.php';
$mandal = $_POST['mandal'];

$query = "SELECT panchayat FROM `tbl_mandal_panchayat_mapping` WHERE `mandal` = '$mandal' GROUP BY panchayat";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>