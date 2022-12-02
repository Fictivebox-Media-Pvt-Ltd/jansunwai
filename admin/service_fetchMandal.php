<?php
include_once '../configs/includes.php';
$query = "SELECT id, vidhansabha,mandal FROM tbl_mandal";

if(isset($_POST["search"]["value"]))
{
	$query .= ' WHERE mandal LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= ' OR'." DATE_FORMAT(created_at, '%d %b, %Y')".' LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $response[$key]['vidhansabha'] = $value[1];
        $response[$key]['mandal'] = $value[2];
    }
}
$i = 1;
foreach($response as $row)
{
	$sub_array = array();
	$sub_array[] = $_POST['start']+$i;
    $sub_array[] = $row['vidhansabha'];
    $sub_array[] = $row['mandal'];
    $sub_array[] =  '<a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete This Mandal.!"><em class="icon ni ni-trash"></em></a>';
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
    $query = "SELECT count(id) as total_records FROM tbl_mandal";
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_records'];
    return $result;
}
echo json_encode($output);
?>