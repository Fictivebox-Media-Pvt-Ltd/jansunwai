<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
$assignedLoksabha = getLoksabhaOfLoggedInUser($conn,$user_id);
$loginUserData = get_user_details($conn, $user_id);
$deptId = $loginUserData['department_id'];
$deptName = get_department_details($conn, $deptId);
$query = '';
$output = array();
$query .= "SELECT tbl_voters.id AS 'id', `file_id`, `loksabha`, `vidhansabha`, `booth_no`, `section_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `sambandh`, `gender_hin`, `ward_hin`, `id_no`, `poling_station_hin`, `poling_station_en`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en` FROM tbl_voters";

if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL && isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
    $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'".' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}else if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL){
    $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'";
}else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['booth_no'] != NULL){
    $query .= ' WHERE tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}

if(isset($_POST["order"]))
{
	$query .= ' ORDER BY '.($_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY id ASC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
//asd($query);
mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);

$data = array();
$filtered_rows = count($result);

foreach($result as $key => $value){
    foreach($value as $innerKey => $innerValue){
        $response[$key]['id'] = $value[0];
        $response[$key]['file_id'] = $value[1];
        $response[$key]['loksabha'] = $value[2];
        $response[$key]['vidhansabha'] = $value[3];
        $response[$key]['booth_no'] = $value[4];
        $response[$key]['section_no'] = $value[5];
        $response[$key]['house_no'] = $value[6];
        $response[$key]['voter_name_hin'] = $value[7];
        $response[$key]['voter_age'] = $value[8];
        $response[$key]['father_husband_name_hin'] = $value[9];
        $response[$key]['sambandh'] = $value[10];
        $response[$key]['gender_hin'] = $value[11];
        $response[$key]['ward_hin'] = $value[12];
        $response[$key]['id_no'] = $value[13];
        $response[$key]['poling_station_hin'] = $value[14];
        $response[$key]['poling_station_en'] = $value[15];
        $response[$key]['voter_name_en'] = $value[16];
        $response[$key]['father_husband_name_en'] = $value[17];
        $response[$key]['gender_en'] = $value[18];
        $response[$key]['ward_en'] = $value[19];


    }
}

$i = 1;
foreach($response as $row)
{
	$sub_array = array();
	$sub_array[] = $_POST['start']+$i;
	$sub_array[] = $row['file_id'];
    $sub_array[] = $row['loksabha'];
    $sub_array[] = $row['vidhansabha'];
    $sub_array[] = $row['booth_no'];
    $sub_array[] = $row['section_no'];
    $sub_array[] = $row['house_no'];
    $sub_array[] = $row['voter_name_hin'];
    $sub_array[] = $row['voter_age'];
    $sub_array[] = $row['father_husband_name_hin'];
    $sub_array[] = $row['sambandh'];
    $sub_array[] = $row['gender_hin'];
    $sub_array[] = $row['ward_hin'];
    $sub_array[] = $row['id_no'];
    $sub_array[] = $row['poling_station_hin'];
    $sub_array[] = $row['poling_station_en'];
    $sub_array[] = $row['voter_name_en'];
    $sub_array[] = $row['father_husband_name_en'];
    $sub_array[] = $row['gender_en'];
    $sub_array[] = $row['ward_en'];
    $sub_array[] =  '<a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete This Voter.!"><em class="icon ni ni-trash"></em></a>';

        $sub_array[] = '<a href="voter_survey.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Do Survey"><button type="button" class="btn btn-primary btn-sm">Survey</button></a>';

	$data[] = $sub_array;
    $i++;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn),
	"data"				=>	$data
);

function get_total_all_records($conn){
    $query = "SELECT count(tbl_voters.id) as total_users FROM tbl_voters LEFT JOIN tbl_voter_survey ON tbl_voters.id = tbl_voter_survey.voter_id ";
    if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL && isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
        $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'".' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
    }else if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL){
        $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'";
    }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['booth_no'] != NULL){
        $query .= ' WHERE tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
    }

    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_users'];
    return $result;
}
echo json_encode($output);
?>
