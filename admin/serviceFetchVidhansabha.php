<?php
include_once '../configs/includes.php';
$loksabha = $_POST['loksabha'];
$query = "SELECT vidhansabha FROM `tbl_vidhansabha` WHERE `loksabha` = '$loksabha' AND `vidhansabha` != '' GROUP BY vidhansabha";

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result,JSON_UNESCAPED_UNICODE);
?>