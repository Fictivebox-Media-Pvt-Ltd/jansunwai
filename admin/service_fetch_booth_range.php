<?php
include_once '../configs/includes.php';
$panchayat = $_POST['panchayat'];

$query = "SELECT booth_range FROM `tbl_panchayat` WHERE `panchayat` = '$panchayat' GROUP BY booth_range";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>