<?php
include_once '../configs/includes.php';
$booth_range = $_POST['booth_range'];
$booth_range = str_replace(' ', '', $booth_range);
$booth_range = explode('~',$booth_range);

$query = "SELECT ward_hin FROM `tbl_voters` WHERE loksabha = 'चित्तौड़गढ़' AND `booth_no` >= $booth_range[0] AND `booth_no` <= $booth_range[1] GROUP BY ward_hin";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>