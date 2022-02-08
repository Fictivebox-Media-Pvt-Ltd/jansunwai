<?php
include_once '../configs/database.php';

if(isset($_GET['id']) && $_GET['id'] != ''){
	$id = $_GET['id'];
}else{
	$id = 'no_value';
}


$query="SELECT id,booth_no,voter_name_hin,father_husband_name_hin,house_no,voter_age,gender_hin,ward_hin FROM tbl_voters " ;
if(!empty($id) && $id != ''){
	$query .= "WHERE id = '$id'";
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
        'voter_id'=>$row['id'],'booth_no'=>$row['booth_no'],'name'=>$row['voter_name_hin'],'gurdian_name'=>$row['father_husband_name_hin'],'house_no'=>$row['house_no'],'voter_age'=>$row['voter_age'],'gender_hin'=>$row['gender_hin'],'ward'=>$row['ward_hin'],
));
        }
                echo json_encode(array("voter_details"=>$info),JSON_UNESCAPED_UNICODE);
}
else {
        echo "false";
}

?>