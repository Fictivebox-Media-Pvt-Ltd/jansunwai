<?php
include_once '../configs/database.php';

if(isset($_GET['ward_name']) && $_GET['ward_name'] != '' && isset($_GET['vidhansabha']) && $_GET['vidhansabha'] != ''){
	$ward_name = $_GET['ward_name'];
        $vidhansabha = $_GET['vidhansabha'];
}else{
	$ward_name = 'no_value';
}


$query="SELECT DISTINCT house_no FROM tbl_voters " ;
if(!empty($ward_name) && $ward_name != ''){
	$query .= "WHERE ward_hin LIKE '%$ward_name%' AND vidhansabha = '$vidhansabha'";
}

mysqli_set_charset($conn,'utf8');
$result=mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
$rows=mysqli_num_rows($result);

$i = 0;
if($rows >0) {
        $info=array();
        while($row=mysqli_fetch_array($result))
        {
$i++;
                array_push($info,array(
        'value'=>$row['house_no'],
));
        }
                echo json_encode(array("house_no"=>$info),JSON_UNESCAPED_UNICODE);
}
else {
        echo "false";
}

?>