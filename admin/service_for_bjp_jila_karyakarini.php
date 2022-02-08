<?php
include_once '../configs/includes.php';
$query = '';
$output = array();

$query .= "SELECT id,district,designation, name, father_name,age,cast,phone_no,address,active_membership_number,previous_designation,nivasi_mandal,dob FROM bjp_jila_karyakarini";
if(isset($_POST["search"]["value"]))
{
	$query .= ' WHERE district LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR father_name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR active_membership_number LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR previous_designation LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR nivasi_mandal LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR dob LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id ASC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

mysqli_set_charset($conn,'utf8');
$value = mysqli_query($conn,$query);
$result = mysqli_fetch_all($value);
$data = array();
$filtered_rows = count($result);

foreach($result as $key => $value){
    foreach($value as $innerKey => $innerValue){
        $response[$key]['id'] = $value[0];
        $response[$key]['district'] = $value[1];
        $response[$key]['designation'] = $value[2];
        $response[$key]['name'] = $value[3];
        $response[$key]['father_name'] = $value[4];
        $response[$key]['age'] = $value[5];
        $response[$key]['cast'] = $value[6];
        $response[$key]['phone_no'] = $value[7];
        $response[$key]['address'] = $value[8];
        $response[$key]['active_membership_number'] = $value[9];
        $response[$key]['previous_designation'] = $value[10];
        $response[$key]['nivasi_mandal'] = $value[11];
        $response[$key]['dob'] = $value[12];
    }
}

$i = 1;
foreach($response as $row)
{
	$sub_array = array();
	$sub_array[] = $_POST['start']+$i;
    $sub_array[] = $row["district"];
    $sub_array[] = $row["designation"];
    $sub_array[] = $row['name'];
    $sub_array[] = $row['father_name'];
    $sub_array[] = $row['age'];
    $sub_array[] = $row['cast'];
    $sub_array[] = $row['phone_no'];
    $sub_array[] = $row['address'];
    $sub_array[] = $row['active_membership_number'];
    $sub_array[] = $row['previous_designation'];
    $sub_array[] = $row['nivasi_mandal'];
    $sub_array[] = $row['dob'];
    $sub_array[] = '<a href="#?id="'.$row["id"].'" class="btn btn-icon btn-trigger btn-tooltip" title="Edit details"><em class="icon ni ni-edit"></em></a><a href="#'.$row["id"].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this member"><em class="icon ni ni-trash"></em></a>';
    $sub_array[] = '<div class="custom-control custom-control-sm custom-checkbox notext"><input type="checkbox" class="custom-control-input chk2" name="check[]" id="'.$row["id"].'" value="'.$row["id"].'" >
    <label class="custom-control-label" for="'.$row["id"].'"></label></div>';
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
    $query = "SELECT count(id) as total_records FROM bjp_jila_karyakarini";
    if(isset($_POST["search"]["value"]))
    {
        $query .= ' WHERE district LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR father_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR active_membership_number LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR previous_designation LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR nivasi_mandal LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR dob LIKE "%'.$_POST["search"]["value"].'%" ';
    }
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_records'];
    return $result;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($output,JSON_UNESCAPED_UNICODE);
?>