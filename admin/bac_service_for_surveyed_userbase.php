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
    $queryForVoterIds = "SELECT `id` FROM `tbl_voters` ";

    if(!empty($filters['loksabha'])){
        $loksabha = $filters['loksabha'];
        $queryForVoterIds .= "WHERE loksabha = '$loksabha' ";
    }    
    if(!empty($filters['vidhansabha'])){
        $vidhansabha = $filters['vidhansabha'];
        $queryForVoterIds .= "AND vidhansabha = '$vidhansabha' ";
    }
    if(!empty($filters['boothRange'])){
        $booth_range = $filters['boothRange'];
        $booth_range = explode('~',$booth_range);
        $queryForVoterIds .= "AND `booth_no` BETWEEN $booth_range[0] AND $booth_range[1] ";
    }else if(!empty($filters['mandal']) && empty($filters['panchayat'])){
        $mandal  = $filters['mandal'];
        $query = "SELECT `booth_range` FROM `tbl_mandal_panchayat_mapping` WHERE `mandal` = '$mandal'";
        $total_booths = mysqli_query($conn,$query);
        $values= mysqli_fetch_all($total_booths);
        foreach($values as $key => $value){
            $values[$key] = explode('~',str_replace(' ', '', $value[0]));
        }
        foreach($values as $k => $v){
            foreach($v as $kv => $vv){
                $booth[] = $vv;
            }
        }
        $min_booth = MIN($booth);
        $max_booth = MAX($booth);
        $queryForVoterIds .= "AND `booth_no` BETWEEN $min_booth AND $max_booth ";
    }else if(!empty($filters['panchayat'])){
        $panchayat  = $filters['panchayat'];
        $query = "SELECT `booth_range` FROM `tbl_mandal_panchayat_mapping` WHERE `panchayat` = '$panchayat'";
        $total_booths = mysqli_query($conn,$query);
        $values= mysqli_fetch_all($total_booths);
        foreach($values as $key => $value){
            $values[$key] = explode('~',str_replace(' ', '', $value[0]));
        }
        foreach($values as $k => $v){
            foreach($v as $kv => $vv){
                $booth[] = $vv;
            }
        }
        $min_booth = MIN($booth);
        $max_booth = MAX($booth);
        $queryForVoterIds .= "AND `booth_no` BETWEEN $min_booth AND $max_booth ";
    }
    if(!empty($filters['ward'])){
        $ward = $filters['ward'];
        $queryForVoterIds .= "AND ward_hin LIKE '%$ward%' ";
    }
    if(!empty($filters['gender'])){
        $gender = $filters['gender'];
        $queryForVoterIds .= "AND gender_hin = '$gender' ";
    }
    if(!empty($filters['ageGroup'])){
        $ageGroup = $filters['ageGroup'];
        $ageGroup = explode('~',$ageGroup);
        $queryForVoterIds .= "AND `voter_age` BETWEEN $ageGroup[0] AND $ageGroup[1] ";
    }

    $queryForVoterIds .= " AND is_surveyed = 1";

    $total_value= mysqli_query($conn,$queryForVoterIds);
    $result= mysqli_fetch_all($total_value);

    foreach($result as $key => $value){
        $response[] = $value[0];
    }
    // asd(count($response));
    return implode(', ', $response);;
}

$filters['loksabha'] = isset($_GET['filter_loksabha']) ? $_GET['filter_loksabha'] : '';
$filters['vidhansabha'] = '';
$filters['boothRange'] = isset($_GET['filter_boothRange']) ? $_GET['filter_boothRange'] : '';
$filters['mandal'] = isset($_GET['filter_mandal']) ? $_GET['filter_mandal'] : '';
$filters['panchayat'] = isset($_GET['filter_panchayat']) ? $_GET['filter_panchayat'] : '';
$filters['ward'] = '';
$filters['gender'] = '';
$filters['ageGroup'] = isset($_GET['filter_ageGroup']) ? $_GET['filter_ageGroup'] : '';

$voter_ids = get_voter_ids($conn,$filters);

$query .= "SELECT tbl_voters.id AS 'id', `file_id`, `loksabha`, `vidhansabha`, `booth_no`, `section_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `sambandh`, `gender_hin`, `ward_hin`, `id_no`, `poling_station_hin`, `poling_station_en`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en`, `pesha`, `mobile_no`, `whatsapp_no`, `pramukh_mudde`, `rating_current_govt`, `voted_2019_loksabha`, `voted_2018_vidhansabha`, `vote_reason_2018`, `vichardhahra`, `corona`, `active_karyakarta`, `vidhansabha_2023`, `caste`, `caste_categories`, `surveyed_by`, tbl_voter_survey.created_at AS surveyed_at FROM tbl_voter_survey INNER JOIN tbl_voters ON tbl_voter_survey.voter_id = tbl_voters.id";
// if($_GET['booth_no'] != '' && $_GET['selected_ward'] != '' && $_GET['voter_name'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'".' AND ward_hin = '."'".$_GET['selected_ward']."' AND voter_name_hin ".' LIKE "%'.$_GET['voter_name'].'%" ';
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['voter_name'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'AND voter_name_hin ".' LIKE "%'.$_GET['voter_name'].'%" ';
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['selected_ward'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'".' AND ward_hin = '."'".$_GET['selected_ward']."'";
// }else if(isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
//     $query .= ' WHERE booth_no = '."'".$_GET['booth_no']."'";
// }

$query .= " WHERE tbl_voters.is_surveyed = 1";

if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL && isset($_GET['booth_no']) && $_GET['booth_no'] != ''){
    $query .= ' AND tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'".' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}else if(isset($_GET['assignedLoksabha']) && $_GET['assignedLoksabha'] != '' && $_GET['assignedLoksabha'] != NULL){
    $query .= ' AND tbl_voters.loksabha = '."'".$_GET['assignedLoksabha']."'";
}else if(isset($_GET['booth_no']) && $_GET['booth_no'] != '' && $_GET['booth_no'] != NULL){
    $query .= ' AND tbl_voters.booth_no = '."'".$_GET['booth_no']."'";
}

if(isset($voter_ids) && $voter_ids != '' && $voter_ids != NULL){
    $query .= " AND tbl_voters.id IN ($voter_ids)";
}
if(isset($_GET['filter_category']) && $_GET['filter_category'] != '' && $_GET['filter_category'] != NULL){
    $query .= " AND tbl_voter_survey.caste_categories LIKE '%".$_GET['filter_category']."%'";
}
if(isset($_GET['filter_caste']) && $_GET['filter_caste'] != '' && $_GET['filter_caste'] != NULL){
    $query .= " AND tbl_voter_survey.caste LIKE '%".trim($_GET['filter_caste'])."%'";
}
if(isset($_GET['filter_pesha']) && $_GET['filter_pesha'] != '' && $_GET['filter_pesha'] != NULL){
    $query .= " AND tbl_voter_survey.pesha LIKE '%".trim($_GET['filter_pesha'])."%'";
}
if(isset($_GET['filter_pramukh_mudde']) && $_GET['filter_pramukh_mudde'] != '' && $_GET['filter_pramukh_mudde'] != NULL){
    $query .= " AND tbl_voter_survey.pramukh_mudde LIKE '%".trim($_GET['filter_pramukh_mudde'])."%'";
}
if(isset($_GET['filter_mojuda_sarkaar']) && $_GET['filter_mojuda_sarkaar'] != '' && $_GET['filter_mojuda_sarkaar'] != NULL){
    $query .= " AND tbl_voter_survey.rating_current_govt LIKE '%".trim($_GET['filter_mojuda_sarkaar'])."%'";
}
if(isset($_GET['filter_2019_loksabha']) && $_GET['filter_2019_loksabha'] != '' && $_GET['filter_2019_loksabha'] != NULL){
    $query .= " AND tbl_voter_survey.voted_2019_loksabha LIKE '%".trim($_GET['filter_2019_loksabha'])."%'";
}
if(isset($_GET['filter_2018_vidhansabha']) && $_GET['filter_2018_vidhansabha'] != '' && $_GET['filter_2018_vidhansabha'] != NULL){
    $query .= " AND tbl_voter_survey.voted_2018_vidhansabha LIKE '%".trim($_GET['filter_2018_vidhansabha'])."%'";
}
if(isset($_GET['filter_partyVsCandidate']) && $_GET['filter_partyVsCandidate'] != '' && $_GET['filter_partyVsCandidate'] != NULL){
    $query .= " AND tbl_voter_survey.vote_reason_2018 LIKE '%".trim($_GET['filter_partyVsCandidate'])."%'";
}
if(isset($_GET['filter_vichardhara']) && $_GET['filter_vichardhara'] != '' && $_GET['filter_vichardhara'] != NULL){
    $query .= " AND tbl_voter_survey.vichardhahra LIKE '%".trim($_GET['filter_vichardhara'])."%'";
}
if(isset($_GET['filter_corona']) && $_GET['filter_corona'] != '' && $_GET['filter_corona'] != NULL){
    $query .= " AND tbl_voter_survey.corona LIKE '%".trim($_GET['filter_corona'])."%'";
}
if(isset($_GET['filter_local_candidate']) && $_GET['filter_local_candidate'] != '' && $_GET['filter_local_candidate'] != NULL){
    $query .= " AND tbl_voter_survey.active_karyakarta LIKE '%".trim($_GET['filter_local_candidate'])."%'";
}
if(isset($_GET['filter_2023_vidhansabha']) && $_GET['filter_2023_vidhansabha'] != '' && $_GET['filter_2023_vidhansabha'] != NULL){
    $query .= " AND tbl_voter_survey.vidhansabha_2023 LIKE '%".trim($_GET['filter_2023_vidhansabha'])."%'";
}

if(isset($_POST["order"]))
{
	$query .= ' ORDER BY '.($_POST['order']['0']['column']+1).' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY tbl_voter_survey.id DESC ';
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
        $response[$key]['surveyed_by'] = $value[34];
        $response[$key]['surveyed_at'] = $value[35];
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
    // $sub_array[] = '<a href="voter_survey.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Do Survey"><button type="button" class="btn btn-primary btn-sm">Survey</button></a>';
    
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
        $sub_array[] = $row['surveyed_by'];
        $sub_array[] = $row['surveyed_at'];
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

function get_total_all_records($conn,$voter_ids){
    $query = "SELECT count(tbl_voters.id) as total_users FROM tbl_voters INNER JOIN tbl_voter_survey ON tbl_voters.id = tbl_voter_survey.voter_id ";
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
        $query .= " AND tbl_voter_survey.caste_categories LIKE '%".$_GET['filter_category']."%'";
    }
    if(isset($_GET['filter_caste']) && $_GET['filter_caste'] != '' && $_GET['filter_caste'] != NULL){
        $query .= " AND tbl_voter_survey.caste LIKE '%".trim($_GET['filter_caste'])."%'";
    }
    if(isset($_GET['filter_pesha']) && $_GET['filter_pesha'] != '' && $_GET['filter_pesha'] != NULL){
        $query .= " AND tbl_voter_survey.pesha LIKE '%".trim($_GET['filter_pesha'])."%'";
    }
    if(isset($_GET['filter_pramukh_mudde']) && $_GET['filter_pramukh_mudde'] != '' && $_GET['filter_pramukh_mudde'] != NULL){
        $query .= " AND tbl_voter_survey.pramukh_mudde LIKE '%".trim($_GET['filter_pramukh_mudde'])."%'";
    }
    if(isset($_GET['filter_mojuda_sarkaar']) && $_GET['filter_mojuda_sarkaar'] != '' && $_GET['filter_mojuda_sarkaar'] != NULL){
        $query .= " AND tbl_voter_survey.rating_current_govt LIKE '%".trim($_GET['filter_mojuda_sarkaar'])."%'";
    }
    if(isset($_GET['filter_2019_loksabha']) && $_GET['filter_2019_loksabha'] != '' && $_GET['filter_2019_loksabha'] != NULL){
        $query .= " AND tbl_voter_survey.voted_2019_loksabha LIKE '%".trim($_GET['filter_2019_loksabha'])."%'";
    }
    if(isset($_GET['filter_2018_vidhansabha']) && $_GET['filter_2018_vidhansabha'] != '' && $_GET['filter_2018_vidhansabha'] != NULL){
        $query .= " AND tbl_voter_survey.voted_2018_vidhansabha LIKE '%".trim($_GET['filter_2018_vidhansabha'])."%'";
    }
    if(isset($_GET['filter_partyVsCandidate']) && $_GET['filter_partyVsCandidate'] != '' && $_GET['filter_partyVsCandidate'] != NULL){
        $query .= " AND tbl_voter_survey.vote_reason_2018 LIKE '%".trim($_GET['filter_partyVsCandidate'])."%'";
    }
    if(isset($_GET['filter_vichardhara']) && $_GET['filter_vichardhara'] != '' && $_GET['filter_vichardhara'] != NULL){
        $query .= " AND tbl_voter_survey.vichardhahra LIKE '%".trim($_GET['filter_vichardhara'])."%'";
    }
    if(isset($_GET['filter_corona']) && $_GET['filter_corona'] != '' && $_GET['filter_corona'] != NULL){
        $query .= " AND tbl_voter_survey.corona LIKE '%".trim($_GET['filter_corona'])."%'";
    }
    if(isset($_GET['filter_local_candidate']) && $_GET['filter_local_candidate'] != '' && $_GET['filter_local_candidate'] != NULL){
        $query .= " AND tbl_voter_survey.active_karyakarta LIKE '%".trim($_GET['filter_local_candidate'])."%'";
    }
    if(isset($_GET['filter_2023_vidhansabha']) && $_GET['filter_2023_vidhansabha'] != '' && $_GET['filter_2023_vidhansabha'] != NULL){
        $query .= " AND tbl_voter_survey.vidhansabha_2023 LIKE '%".trim($_GET['filter_2023_vidhansabha'])."%'";
    }
    
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_users'];
    return $result;
}
echo json_encode($output);
?>
