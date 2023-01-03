<?php
include_once '../configs/includes.php';
$query = "SELECT id,loksabha,vidhansabha,question_heading,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,status FROM tbl_survey_questions";

if(isset($_POST["search"]["value"]))
{
	$query .= ' WHERE question LIKE "%'.$_POST["search"]["value"].'%" ';
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
        $response[$key]['loksabha'] = $value[1];
        $response[$key]['vidhansabha'] = $value[2];
        $response[$key]['question_heading'] = $value[3];
        $response[$key]['question'] = $value[4];
        $response[$key]['option1'] = $value[5];
        $response[$key]['option2'] = $value[6];
        $response[$key]['option3'] = $value[7];
        $response[$key]['option4'] = $value[8];
        $response[$key]['option5'] = $value[9];
        $response[$key]['option6'] = $value[10];
        $response[$key]['option7'] = $value[11];
        $response[$key]['option8'] = $value[12];
        $response[$key]['option9'] = $value[13];
        $response[$key]['option10'] = $value[14];
        $response[$key]['status'] = $value[15];
    }
}
$i = 1;
foreach($response as $row)
{
	$sub_array = array();
	$sub_array[] = $_POST['start']+$i;
    $sub_array[] = $row['loksabha'];
    $sub_array[] = $row['vidhansabha'];
    $sub_array[] = $row['question_heading'];
    $sub_array[] = $row['question'];
    $sub_array[] = $row['option1'];
    $sub_array[] = $row['option2'];
    $sub_array[] = $row['option3'];
    $sub_array[] = $row['option4'];
    $sub_array[] = $row['option5'];
    $sub_array[] = $row['option6'];
    $sub_array[] = $row['option7'];
    $sub_array[] = $row['option8'];
    $sub_array[] = $row['option9'];
    $sub_array[] = $row['option10'];

    if($row['status'] == 1){
        $sub_array[] ='<a href="?changeStatus='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Edit this Question"><em class="icon ni ni-trash"></em> Active </a>';
    }
    else{
        $sub_array[] ='<a href="?changeStatus='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Edit this Question"><em class="icon ni ni-trash"></em> Inactive</a>';
    }
    $sub_array[] = '<a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete This Question.!"><em class="icon ni ni-trash"></em></a>'.
        '<a href="edit_question.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Edit this Question"><em class="icon ni ni-edit"></em></a>';
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
    $query = "SELECT count(id) as total_records FROM tbl_survey_questions";
    $value= mysqli_query($conn,$query);
    $result = mysqli_fetch_assoc($value)['total_records'];
    return $result;
}
echo json_encode($output);
?>