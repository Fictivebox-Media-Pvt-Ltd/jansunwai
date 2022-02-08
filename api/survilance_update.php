<?php
include_once '../configs/database.php';

if(isset($_GET['username']) && isset($_GET['latitude']) && isset($_GET['longitude'])){
        if($_GET['username'] != '' && $_GET['latitude']!= '' && $_GET['longitude']!= ''){
                $username = $_GET['username'];
                $latitude = $_GET['latitude'];
                $longitude = $_GET['longitude'];
        }else{
                echo true;
                return true;
        }
}else{
        echo true;
        return;
}

$query="SELECT * FROM `tbl_survilance` WHERE `username` = '$username'" ;

mysqli_set_charset($conn,'utf8');
$result=mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
$rows=mysqli_num_rows($result);

if($rows >0) {
        $survilance_query = "UPDATE `tbl_survilance` SET `latitude` = '$latitude', `longitude` = '$longitude', `last_updated_at` = now() WHERE `username` = '$username';";
}
else {
        $survilance_query = "INSERT INTO `tbl_survilance` (`username`, `latitude`, `longitude`, `last_updated_at`) VALUES ('$username', '$latitude', '$longitude', now());";
}

mysqli_query($conn,$survilance_query);
echo true;
return true;
?>