<?php
include_once '../configs/includes.php';
$vidhansabha = $_POST['vidhansabha'];
$query = "SELECT mandal FROM `tbl_mandal` WHERE `mandal` != '' AND `vidhansabha` = '$vidhansabha' GROUP BY mandal";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>