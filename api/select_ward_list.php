<?php
include_once '../configs/database.php';

if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && isset($_GET['vidhansabha']) && $_GET['vidhansabha'] != ''){
	$booth_no = $_GET['booth_no'];
        $vidhansabha = $_GET['vidhansabha'];
}else{
	$booth_no = 'no_value';
}


$query="SELECT DISTINCT ward_hin FROM tbl_voters " ;
if(!empty($booth_no) && $booth_no != ''){
	$query .= "WHERE booth_no = '$booth_no' AND vidhansabha = '$vidhansabha'";
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
        'value'=>$row['ward_hin'],
));
        }
                echo json_encode(array("ward"=>$info),JSON_UNESCAPED_UNICODE);
}
else {
        echo "false";
}

?>