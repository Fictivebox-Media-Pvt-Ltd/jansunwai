<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
$loginUserData = get_user_details($conn, $user_id);
$deptId = $loginUserData['department_id'];
$deptName = get_department_details($conn, $deptId);
$query = '';
$output = array();

function get_voter_ids($conn,$filters){
    $response = array();
    $booths = array();
    $queryForVoterIds = "SELECT `voter_id` FROM `tbl_voters` JOIN `tbl_survey` ON tbl_survey.voter_id = 
      tbl_voters.id where tbl_voters.is_surveyed = 1 ";
    if(!empty($filters['loksabha'])){
        $loksabha = $filters['loksabha'];
        $queryForVoterIds .= " AND tbl_voters.loksabha = '$loksabha'";
    }    
    if(!empty($filters['vidhansabha'])){
        $vidhansabha = $filters['vidhansabha'];
        $queryForVoterIds .= " AND tbl_voters.vidhansabha = '$vidhansabha'";
    }
    if(!empty($filters['filter_mandal'])){
        $filter_mandal = $filters['filter_mandal'];
        $queryForVoterIds .= " AND tbl_voters.mandal = $filter_mandal";
    }
    if(!empty($filters['filter_panchayat'])){
        $filter_panchayat = $filters['filter_panchayat'];
        $queryForVoterIds .= " AND tbl_voters.panchayat = $filter_panchayat";
    }

    if(!empty($filters['boothRange'])){
        $booth_range = $filters['boothRange'];
        $queryForVoterIds .= " AND tbl_voters.booth_no = $booth_range";
    }

    if(!empty($filters['optionFilters'])){
        $optionFilters = $filters['optionFilters'];
        $queryForVoterIds .= " AND find_in_set(tbl_survey.selected_options,'$optionFilters')";
    }
    $total_value= mysqli_query($conn,$queryForVoterIds);
    $result= mysqli_fetch_all($total_value);

    foreach($result as $key => $value){
        $response[] = $value[0];
    }
    return implode(', ', $response);;
}

$filters['loksabha'] = isset($_GET['assignedLoksabha']) ? $_GET['assignedLoksabha'] : '';
$filters['optionFilters'] = isset($_GET['optionFilters']) ? $_GET['optionFilters'] : '';
// $filters['vidhansabha'] = '';
$filters['boothRange'] = isset($_GET['filter_boothRange']) ? $_GET['filter_boothRange'] : '';
$filters['filter_panchayat'] = isset($_GET['filter_panchayat']) ? $_GET['filter_panchayat'] : '';
$filters['filter_mandal'] = isset($_GET['filter_mandal']) ? $_GET['filter_mandal'] : '';

if(!empty($_GET['assignedLoksabha'])){
    $assignedLoksabha = $_GET['assignedLoksabha'];
    $queryQuestionOption = "SELECT `id`,`question_heading` FROM `tbl_survey_questions` WHERE loksabha = '$assignedLoksabha' AND `question_heading` != '' AND status = '1' ";

}
else{
    $queryQuestionOption = "SELECT `id`,`question_heading` FROM `tbl_survey_questions`  WHERE `question_heading` != '' AND status = '1' ";   
}

$valueQuestionOption = mysqli_query($conn,$queryQuestionOption);
$queryQuestionOptionResult = mysqli_fetch_all($valueQuestionOption);
//asd($result);

$voter_ids = get_voter_ids($conn,$filters);
$query .= "SELECT DISTINCT tbl_voters.id,tbl_voters.file_id,tbl_voters.loksabha,tbl_voters.vidhansabha,tbl_voters.booth_no, tbl_voters.section_no,tbl_voters.house_no,tbl_voters.voter_name_hin,tbl_voters.voter_age, tbl_voters.father_husband_name_hin,tbl_voters.sambandh,tbl_voters.gender_hin,tbl_voters.ward_hin,tbl_voters.id_no, tbl_voters.poling_station_hin,tbl_voters.poling_station_en,tbl_voters.voter_name_en, tbl_voters.father_husband_name_en,tbl_voters.gender_en,tbl_voters.ward_en FROM tbl_voters JOIN tbl_survey ON tbl_survey.voter_id = 
tbl_voters.id WHERE tbl_voters.is_surveyed = 1 ";

if(!empty($filters['loksabha'])){
    $loksabha = $filters['loksabha'];
    $query .= " AND tbl_voters.loksabha = '$loksabha'";
}    
if(!empty($filters['vidhansabha'])){
    $vidhansabha = $filters['vidhansabha'];
    $query .= " AND tbl_voters.vidhansabha = '$vidhansabha'";
}
if(!empty($filters['filter_mandal'])){
    $filter_mandal = $filters['filter_mandal'];
    $query .= " AND tbl_voters.mandal = $filter_mandal";
}
if(!empty($filters['filter_panchayat'])){
    $filter_panchayat = $filters['filter_panchayat'];
    $query .= " AND tbl_voters.panchayat = $filter_panchayat";
}
if(!empty($filters['boothRange'])){
    $booth_range = $filters['boothRange'];
    $query .= " AND tbl_voters.booth_no = $booth_range";
}

if(!empty($filters['optionFilters'])){
    $optionFilters = $filters['optionFilters'];
    $query .= " AND find_in_set(tbl_survey.selected_options,'$optionFilters')";
}


if(isset($_POST["order"]))
{
	$query .= ' ORDER BY '.($_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY id DESC ';
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
//asd($query);
foreach($result as $key => $value){
  // asd($value);
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
//asd($response);
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
    // $sub_array[] = '<a href="voter_survey.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Do Survey"><button type="button" class="btn btn-primary btn-sm">Survey</button></a>';
    
    if(strtolower($deptName) != 'field worker'){
        $voterId = $row['id'];
        $querysurvayerdetail = "SELECT survey_date,username FROM tbl_survey AS ts JOIN tbl_admin_users AS tau ON ts.surveyed_by = tau.id WHERE ts.voter_id = $voterId";   
        $valuequerysurvayerdetail = mysqli_query($conn,$querysurvayerdetail);
        $resultsurveyerdetials = mysqli_fetch_row($valuequerysurvayerdetail); 
        foreach($queryQuestionOptionResult as $key => $questionoption){
           // $voterId =10284;
           
            $questionId = $questionoption[0]; 
            $questionHeading = $questionoption[1]; 
           $querySurvayAnswer = "SELECT `selected_options` FROM `tbl_survey`  WHERE `voter_id` = $voterId  AND 
                `question_id` =$questionId";   
           
           $value = mysqli_query($conn,$querySurvayAnswer);
           $resultSurvayAnswer = mysqli_fetch_row($value);
           $sub_array[] = $resultSurvayAnswer;
  
       }
       $sub_array[] = $resultsurveyerdetials[1];
       $sub_array[] = $resultsurveyerdetials[0];

    $sub_array[] = '<a target="_blank" href="update_voters_survey.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Update Survey"><em class="icon ni ni-edit"></em</a>';
        $sub_array[] = '<div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input chk2" name="mobile[]" id="'.$row['id'].'" value="'.$row['mobile_no'].'" >
                                                                    <label class="custom-control-label" for="'.$row['id'].'"></label>
                        </div>';

    }

	$data[] = $sub_array;
    $i++;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$voter_ids),
	"data"				=>	$data
);
//asd($voter_ids);
function get_total_all_records($conn,$voter_ids){
    //asd($voter_ids);
    $query = "SELECT count(tbl_voters.id) as total_users FROM tbl_voters INNER JOIN tbl_survey ON tbl_voters.id = tbl_survey.voter_id ";
    $query .= " WHERE tbl_voters.is_surveyed = 1";
    if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL && isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
        $query .= ' AND tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'".' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
    }else if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL){
        $query .= ' AND tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'";
    }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['booth_no'] != NULL){
        $query .= ' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
    }
    if(isset($voter_ids)){
        $query .= " AND tbl_voters.id IN ($voter_ids)";
    }
    if(isset($_GET['filter_category']) && $_GET['filter_category'] != '' && $_GET['filter_category'] != NULL){
        $query .= " AND tbl_survey.caste_categories LIKE '%".$_GET['filter_category']."%'";
    }
  //asd($query);

    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_users'];
    return $result;
}
echo json_encode($output);
?>
