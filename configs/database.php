<?php


$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "voter";

$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connection failed: %s\n". $conn -> error);
mysqli_set_charset($conn,'utf8');
return $conn;
?>
