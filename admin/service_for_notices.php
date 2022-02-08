<?php
include_once '../configs/includes.php';
$query = '';
$output = array();
$query .= "SELECT id, order_heading, DATE_FORMAT(created_at, '%d %b, %Y') as created_at, is_approved FROM tbl_governance_order ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE order_heading LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR'." DATE_FORMAT(created_at, '%d %b, %Y')".' LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
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
        $response[$key]['order_heading'] = $value[1];
        $response[$key]['created_at'] = $value[2];
		$response[$key]['is_approved'] = $value[3];
    }
}

$i = 1;
foreach($response as $row)
{
	$sub_array = array();
	$sub_array[] = $_POST['start']+$i;
	$sub_array[] = (string)$row["created_at"];
    $order_heading = $row['order_heading'];
	$sub_array[] = $order_heading;
	if($row['is_approved']){
		$sub_array[] = '<a href="?discard='.$row['id'].'"" class="btn btn-icon btn-trigger btn-tooltip" title="Discard this notice"><em class="icon ni ni-cross-circle"></em></a><a href="edit_governance_order.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Update this notice"><em class="icon ni ni-edit"></em></a><a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this notice"><em class="icon ni ni-trash"></em></a>';
	}else{
		$sub_array[] = '<a href="?approve='.$row['id'].'"" class="btn btn-icon btn-trigger btn-tooltip" title="Approve this notice"><em class="icon ni ni-check-circle"></em></a><a href="edit_governance_order.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Update this notice"><em class="icon ni ni-edit"></em></a><a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this notice"><em class="icon ni ni-trash"></em></a>';
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
    $query = "SELECT count(id) as total_notices FROM tbl_governance_order";
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_notices'];
    return $result;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($output,JSON_UNESCAPED_UNICODE);
?>