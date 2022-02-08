<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_sarpanch_candidate";
    $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['loksabha'] = $value[1];
            $response[$key]['vidhansabha'] = $value[2];
            $response[$key]['mandal'] = $value[3];
            $response[$key]['panchayat'] = $value[4];
            $response[$key]['booth'] = $value[5];
            $response[$key]['name'] = $value[6];
            $response[$key]['fathers_name'] = $value[7];
            $response[$key]['age'] = $value[8];
            $response[$key]['caste'] = $value[9];
            $response[$key]['mobile'] = $value[10];
            $response[$key]['address'] = $value[11];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[12]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[13]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[14]));
            $response[$key]['status'] = $value[15];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }

    $filtered_rows = count($result);
    $i = 1;
    foreach($response as $row)
    {
        $sub_array = array();
        $sub_array[] = $_POST['start']+$i;
        $sub_array[] = $row['loksabha'];
        $sub_array[] = $row['vidhansabha'];
        $sub_array[] = $row['mandal'];
        $sub_array[] = $row['panchayat'];
        $sub_array[] = $row['booth'];
        $sub_array[] = $row['name'];
        $sub_array[] = $row['fathers_name'];
        $sub_array[] = $row['age'];
        $sub_array[] = $row['caste'];
        $sub_array[] = $row['mobile'];
        $sub_array[] = $row['address'];
        $sub_array[] = $row['kab_se'];
        $sub_array[] = $row['kab_tak'];
        $sub_array[] = $row['dob'];
        $sub_array[] = $row['status'];
        $sub_array[] =  '<a href="?del='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Delete This Voter.!"><em class="icon ni ni-trash"></em></a>'.
                          '<a href="edit_sarpanch_candidate.php?id='.$row['id'].'" class="btn btn-icon btn-trigger btn-tooltip" title="Edit this member"><em class="icon ni ni-edit"></em></a>';
        $sub_array[] =  '<div class="custom-control custom-control-sm custom-checkbox notext">'.
                        '<input type="checkbox" class="custom-control-input chk2" name="mobile[]" id="'.$row['id'].'" value="'.$row['mobile'].'" >'.
                        '<label class="custom-control-label" for="'.$row['id'].'"></label></div>';

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
        $query = "SELECT count(id) AS total_users FROM tbl_sarpanch_candidate";
        $value= mysqli_query($conn,$query);
        $result = mysqli_fetch_assoc($value)['total_users'];
        return $result;
    }
    echo json_encode($output);
?>
