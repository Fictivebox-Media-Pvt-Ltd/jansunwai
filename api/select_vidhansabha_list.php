<?php
include_once '../configs/database.php';

$query="SELECT DISTINCT vidhansabha FROM tbl_voters " ;
mysqli_set_charset($conn,'utf8');
$result=mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
$rows=mysqli_num_rows($result);

if($rows >0) {
	$info=array();
	while($row=mysqli_fetch_array($result))
	{
		array_push($info,array(
	$row['vidhansabha'],
));
	}
		echo json_encode(array("vidhansabha"=>$info),JSON_UNESCAPED_UNICODE);
}
else {
	echo "false";
}

?>