<?php
include_once '../configs/database.php';
set_time_limit(300);
error_reporting(0);
ini_set('display_errors', '0');
date_default_timezone_set("Asia/Calcutta");

if($_GET['vidhansabha'] != '' && $_GET['booth_no']!= '' && $_GET['ward_hin']!= ''){
        $vidhansabha = $_GET['vidhansabha'];
        $booth_no = $_GET['booth_no'];
        $ward_hin = $_GET['ward_hin']; // ward
        $voter_name_hin = isset($_GET['name']) ? $_GET['name'] : ''; // Optional
        $house_no = isset($_GET['house_no']) ? $_GET['house_no'] : '0'; // Optional
}else if($_GET['vidhansabha'] != '' && $_GET['booth_no']!= '' ){ 
        $vidhansabha = $_GET['vidhansabha'];
        $booth_no = $_GET['booth_no'];
        $ward_hin = 'no_value';
        $voter_name_hin = isset($_GET['name']) ? $_GET['name'] : ''; // Optional
        $house_no = isset($_GET['house_no']) ? $_GET['house_no'] : '0'; // Optional
}else{
        $vidhansabha = 'no_value';
        $booth_no = 'no_value';
        $ward_hin = 'no_value';
        $voter_name_hin = 'no_value';
        $house_no = '0';
}

$voterIdsThatHasBeenSurveyed = array();
$queryForVoterIds = "SELECT * FROM (SELECT voter_id FROM `tbl_mumbai_voter_survey` UNION SELECT voter_id FROM `tbl_voter_survey`) as voter_ids";
$queryForVoterIdsResult = mysqli_query($conn,$queryForVoterIds);
$voterIds = mysqli_fetch_all($queryForVoterIdsResult);
        foreach($voterIds as $key => $value){
                $voterIdsThatHasBeenSurveyed[] = $value[0];
        }

$query="SELECT * FROM `tbl_voters` WHERE id NOT IN (" . implode( ", " , $voterIdsThatHasBeenSurveyed ) . ") AND `vidhansabha` = '$vidhansabha' AND `booth_no` = '$booth_no'" ;

if($ward_hin != 'no_value' && $ward_hin != 'वार्ड चुने'){
        $query .= "AND `ward_hin` = '$ward_hin'";
}

if($house_no != '0' && $house_no != 0 && $house_no != 'मकान सं चुने'){
        $query .= "AND `house_no` = '$house_no'";
}

if($voter_name_hin != '' && $voter_name_hin != 'वोटर का नाम'){
        $query .= "AND `voter_name_hin` LIKE '%$voter_name_hin%'";
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
        'id'=>$row['id'],'house_no'=>$row['house_no'],'name'=>$row['voter_name_hin'],'age'=>$row['voter_age'],'father_husband_name'=>$row['father_husband_name_hin'],
));
        }
                echo json_encode(array("voters_list"=>$info),JSON_UNESCAPED_UNICODE);
}
else {
        echo true;
        return;
}

?>