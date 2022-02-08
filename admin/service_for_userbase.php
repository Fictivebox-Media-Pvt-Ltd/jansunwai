<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
$assignedLoksabha = getLoksabhaOfLoggedInUser($conn,$user_id);
$loginUserData = get_user_details($conn, $user_id);
$deptId = $loginUserData['department_id'];
$deptName = get_department_details($conn, $deptId);
$query = '';
$output = array();
$query .= "SELECT tbl_voters.id AS 'id', `file_id`, `loksabha`, `vidhansabha`, `booth_no`, `section_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `sambandh`, `gender_hin`, `ward_hin`, `id_no`, `poling_station_hin`, `poling_station_en`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en`, `pesha`, `mobile_no`, `whatsapp_no`, `pramukh_mudde`, `rating_current_govt`, `voted_2019_loksabha`, `voted_2018_vidhansabha`, `vote_reason_2018`, `vichardhahra`, `corona`, `active_karyakarta`, `vidhansabha_2023`, `caste`, `caste_categories` FROM tbl_voters LEFT JOIN tbl_voter_survey ON tbl_voters.id = tbl_voter_survey.voter_id";
// if($_GET['booth_no'] != '' && $_GET['selected_ward'] != '' && $_GET['voter_name'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'".' AND ward_hin = '."'".$_GET['selected_ward']."' AND voter_name_hin ".' LIKE "%'.$_GET['voter_name'].'%" ';
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['voter_name'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'AND voter_name_hin ".' LIKE "%'.$_GET['voter_name'].'%" ';
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['selected_ward'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'".' AND ward_hin = '."'".$_GET['selected_ward']."'";
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'";
// }
if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL && isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
    $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'".' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}else if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL){
    $query .= ' WHERE tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'";
}else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['booth_no'] != NULL){
    $query .= ' WHERE tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}

// if(isset($_POST["search"]["value"]) && !isset($_GET['selected_ward']) && !isset($_GET['booth_no']))
// {
// 	$query .= ' WHERE file_id LIKE "%'.$_POST["search"]["value"].'%" ';
// 	$query .= 'OR'." vidhansabha".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." booth_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." house_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." voter_name_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." voter_age".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." father_husband_name_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." gender_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." ward_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." cast_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." phone_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." pesha_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." voter_name_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." father_husband_name_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." gender_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." ward_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." cast_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
//     $query .= 'OR'." pesha_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
// }
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
// asd($query);
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

     if(strtolower($deptName) != 'field worker'){
        $response[$key]['pesha'] = $value[20];
        $response[$key]['mobile_no'] = $value[21];
        $response[$key]['whatsapp_no'] = $value[22];
        $response[$key]['pramukh_mudde'] = $value[23];
        $response[$key]['rating_current_govt'] = $value[24];
        $response[$key]['voted_2019_loksabha'] = $value[25];
        $response[$key]['voted_2018_vidhansabha'] = $value[26];
        $response[$key]['vote_reason_2018'] = $value[27];
        $response[$key]['vichardhahra'] = $value[28];
        $response[$key]['corona'] = $value[29];
        $response[$key]['active_karyakarta'] = $value[30];
        $response[$key]['vidhansabha_2023'] = $value[31];
        $response[$key]['caste'] = $value[32];
        $response[$key]['caste_categories'] = $value[33];
     }

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
    if($assignedLoksabha != 'मुंबई साउथ'){
        $sub_array[] = '<a href="voter_survey.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Do Survey"><button type="button" class="btn btn-primary btn-sm">Survey</button></a>';
    
    if(strtolower($deptName) != 'field worker'){
        $sub_array[] = $row['pesha'];
        $sub_array[] = $row['mobile_no'];
        $sub_array[] = $row['whatsapp_no'];
        $sub_array[] = $row['pramukh_mudde'];
        $sub_array[] = $row['rating_current_govt'];
        $sub_array[] = $row['voted_2019_loksabha'];
        $sub_array[] = $row['voted_2018_vidhansabha'];
        $sub_array[] = $row['vote_reason_2018'];
        $sub_array[] = $row['vichardhahra'];
        $sub_array[] = $row['corona'];
        $sub_array[] = $row['active_karyakarta'];
        $sub_array[] = $row['vidhansabha_2023'];
        $sub_array[] = $row['caste'];
        $sub_array[] = $row['caste_categories'];
        }
    }

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

    // if(isset($_POST["search"]["value"]))
    // {
    //     $query .= ' WHERE file_id LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." vidhansabha".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." booth_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." house_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." voter_name_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." voter_age".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." father_husband_name_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." gender_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." ward_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." cast_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." phone_no".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." pesha_hin".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." voter_name_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." father_husband_name_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." gender_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." ward_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." cast_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    //     $query .= 'OR'." pesha_en".' LIKE "%'.$_POST["search"]["value"].'%" ';
    // }
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_users'];
    return $result;
}
echo json_encode($output);
?>
