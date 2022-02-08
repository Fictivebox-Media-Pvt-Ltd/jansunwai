<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "TySX9^c6e!C_8QcM";
$db = "jansunwai";

$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connection failed: %s\n". $conn -> error);
mysqli_set_charset($conn,'utf8');
return $conn;
?>
