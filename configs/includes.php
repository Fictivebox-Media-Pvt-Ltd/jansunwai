<?php
set_time_limit(300);
error_reporting(0);
ini_set('display_errors', '0');
date_default_timezone_set('Asia/Kolkata');
session_start();

/*
 * Here we'll include all those files which is required for inner application business-logic
 */

$conn = include_once 'database.php';

/*
 * Configurations for bulkupload xlsx files
 */

$counter = 0;
$skipRows = 1;
$skipColumns = 1;

function asd($data, $flg=1){
    if($flg){
        echo '<pre>';
        print_r($data);
        die;
    }else{
        echo '<pre>';
        print_r($data);
    }
}
 
function admin_profile_update($conn,$profile_image='',$f_name='',$l_name='',$admin_email=''){
    $query = "UPDATE `tbl_admin_users` SET ";
    
    if(!empty($f_name)){
        $query = $query."`f_name` = '$f_name', ";
    }
    if(!empty($l_name)){
        $query = $query."`l_name` = '$l_name', ";
    }
    if(!empty($profile_image)){
        $query = $query."`user_image` = '$profile_image', ";
    }
    if(!empty($admin_email)){
        $query = $query."`email` = '$admin_email', ";
    }

    $query = $query."`updated_at` = now() WHERE `id` = ".$_SESSION['user_id'].";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function admin_password_reset($new_password,$conn){
    $query = "UPDATE `tbl_admin_users` SET `password` = '$new_password', `updated_at` = now() WHERE `id` = ".$_SESSION['user_id'].";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_dept($dept_name,$conn){
    $query = "INSERT INTO tbl_department (name) VALUES ('$dept_name')";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function get_all_dept($conn){
    $response = array();

    $query = "SELECT * FROM tbl_department where name != 'Super Admin'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['id'] = $value[0];
                $response[$key]['name'] = $value[1];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function update_dept($conn,$selected_dept,$update_dept_name){
    $query = "UPDATE tbl_department SET Name = '$update_dept_name' WHERE id = $selected_dept";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;

}

function delete_dept($conn,$selected_dept){
    $query = "DELETE FROM tbl_department WHERE id = $selected_dept";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;

}

function get_user_details($conn,$user_id){
    $query = "SELECT department_id,f_name,l_name,user_image,email,username,assigned_loksabha FROM tbl_admin_users WHERE id=$user_id";
    mysqli_set_charset($conn,'utf8');
    $loginUser = mysqli_query($conn, $query);
    $loginUserData = mysqli_fetch_assoc($loginUser);
    return $loginUserData;
}

function get_department_details($conn,$deptId){
    $dept = "SELECT name FROM tbl_department WHERE id=$deptId";
    mysqli_set_charset($conn,'utf8');
    $deptData = mysqli_query($conn, $dept);
    $deptName = mysqli_fetch_assoc($deptData)['name'];
    return $deptName;
}

function add_dept_admin($conn,$profile_image,$f_name,$l_name='',$admin_email,$admin_username,$selected_dept,$password,$loksabha,$vidhansabha,$phone_no,$aardhar_no){
    $phone_no = !empty($phone_no) ? $phone_no : 'NULL';
    $aardhar_no = !empty($aardhar_no) ? $aardhar_no : 'NULL';
    $profile_image = !empty($profile_image) ? $profile_image : 'noImageWasSelected.png';
    $query = "INSERT INTO `tbl_admin_users` (`department_id`, `f_name`, `l_name`, `user_image`, `email`, `username`, `password`, `created_at`, `updated_at`, `assigned_loksabha`, `assigned_vidhansabha`, `phone_no`, `aadhar_no`) VALUES ($selected_dept, '$f_name', '$l_name', '$profile_image', '$admin_email', '$admin_username', '$password', now(), NULL,'$loksabha','$vidhansabha',$phone_no,$aardhar_no)";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_client_ip(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
     }else
     {
         $ip_address = $_SERVER['REMOTE_ADDR'];
     }
     return $ip_address;
 }
 
 function get_user_counts($conn){
    $query = "select count(id) as total_users from tbl_users;";
    mysqli_set_charset($conn,'utf8');
        $value= mysqli_query($conn,$query);
      $result= mysqli_fetch_assoc($value);
    return $result['total_users'];
 }
function user_login($conn,$username,$password){
    $query = "SELECT id FROM tbl_admin_users WHERE username="."'".$username."'"." AND password="."'".$password."'";
    mysqli_set_charset($conn,'utf8');
    $loginUser = mysqli_query($conn,$query);
    if(isset($loginUser->num_rows)){
        $loginUserData = mysqli_fetch_assoc($loginUser);
        $_SESSION['user_id'] = $loginUserData['id'];
        header("Location: index.php"); 
    }else{
        return;
    }
}

function add_governance_order($conn,$govorder_document,$order){
    $query = "INSERT INTO `tbl_governance_order` (`document`, `order_heading`, `created_at`, `updated_at`) VALUES ('$govorder_document', '$order', NOW(), NULL);";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_governance_order($conn,$notice_id){
    $response = array();
    $query = "SELECT id, order_heading, DATE_FORMAT(created_at, '%d %b, %Y') FROM tbl_governance_order";
    $query = isset($notice_id) ? $query." where id = $notice_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['order_heading'] = $value[1];
            $response[$key]['created_at'] = $value[2];
        }
    }
    if(count($response) > 1 || !isset($notice_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    return $response;
}
function deleteQuestion($conn,$id){
    $query = "DELETE FROM `tbl_survey_questions` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}
function deletePanchayat($conn,$id){
    $query = "DELETE FROM `tbl_panchayat` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}
function deleteMandal($conn,$id){
    $query = "DELETE FROM `tbl_mandal` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}



function deleteVidhansabha($conn,$id){
    $query = "DELETE FROM `tbl_vidhansabha` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function deleteLoksabha($conn,$id){
    $query = "DELETE FROM `tbl_loksabha` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function delete_governance_order($conn,$id){
    $query = "DELETE FROM `tbl_governance_order` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}


function approve_governance_order($conn,$id){
    $query = "UPDATE `tbl_governance_order` SET is_approved = 1, updated_at = now() WHERE id = $id";
    mysqli_query($conn, $query);
    return;
}

function discard_governance_order($conn,$id){
    $query = "UPDATE `tbl_governance_order` SET is_approved = 0, updated_at = now() WHERE id = $id";
    mysqli_query($conn, $query);
    return;
}

function update_govern_order($conn,$govorder_document,$order,$id){
  if($govorder_document !=''){
    $query = "UPDATE tbl_governance_order SET document = '$govorder_document' , order_heading ='$order' WHERE id = $id";
  
  }
  else{
    $query = "UPDATE tbl_governance_order SET order_heading ='$order' WHERE id = $id";
  }
   try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}
function publish_page($conn,$page_name,$text_content){
    $isExistQuery = "SELECT COUNT(id) AS isPageExist FROM tbl_pages WHERE page_name = '$page_name'";
    $value= mysqli_query($conn,$isExistQuery);
    $isExist= mysqli_fetch_assoc($value)['isPageExist'];
    if($isExist){
        $query = "UPDATE tbl_pages SET page_content = '$text_content', updated_at = now() WHERE page_name = '$page_name'";
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn,$query);
    }else{
        $query = "INSERT INTO tbl_pages(page_name,page_content,created_at)VALUE('$page_name','$text_content',now())";
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn,$query);
    }
    return;
}

function get_page_content($conn,$page_name){
    $response = '';
    $result = '';
    $query = "SELECT page_content FROM tbl_pages where page_name = '$page_name'";
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    if(!empty($value)){
        $result= mysqli_fetch_assoc($value);
    }
    if($result)
        return $result;
    else
        return $response;
}


function get_users($conn){
    $response = array();
    $query = "SELECT id, f_name, l_name,user_image,aadhar_no,email_id,ph_no,dob,dom FROM tbl_users";
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['f_name'] = $value[1];
            $response[$key]['l_name'] = $value[2];
            $response[$key]['user_image'] = $value[3];
            $response[$key]['aadhar_no'] = $value[4];
            $response[$key]['email_id'] = $value[5];
            $response[$key]['ph_no'] = $value[6];
            $response[$key]['dob'] = $value[7];
            $response[$key]['dom'] = $value[8];
        }
    }
    return $response;
}

function get_bjp_workers($conn,$worker_id){
    $response = array();
    $query = "SELECT id, f_name, l_name, user_image, email, phone_no, aadhar_no, dob, dom FROM tbl_bjp_workers";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['f_name'] = $value[1];
            $response[$key]['l_name'] = isset($value[2]) ? $value[2] : '' ;
            $response[$key]['user_image'] = $value[3];
            $response[$key]['email'] = $value[4];
            $response[$key]['phone_no'] = $value[5];
            $response[$key]['aadhar_no'] = $value[6];
            $response[$key]['dob'] = $value[7];
            $response[$key]['dom'] = $value[8];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    return $response;
}

function add_worker($conn,$user_image,$f_name,$l_name='',$worker_email='',$phone_no,$aadhar_no,$dob,$dom=''){
    $dob = strtotime($dob);
    $dob = date('Y-m-d',$dob);

    if(isset($dom) && $dom != '' && $dom != NULL){
        $dom = strtotime($dom);
        $dom = "'".date('Y-m-d',$dom)."'";
    }else{
        $dom = "NULL";
    }
    $query = "INSERT INTO `tbl_bjp_workers` (`f_name`, `l_name`, `user_image`, `email`, `phone_no`, `aadhar_no`, `dob`, `dom`, `created_at`, `updated_at`) VALUES ('$f_name', '$l_name', '$user_image', '$worker_email', '$phone_no', '$aadhar_no', '$dob', $dom, now(), NULL)";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function delete_worker($conn,$id){
    $query = "DELETE FROM `tbl_bjp_workers` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function update_worker($conn,$karyakarta_id,$image_upload,$f_name,$l_name,$worker_email,$phone_no,$aadhar_no,$dob,$dom){
    $query = "UPDATE `tbl_bjp_workers` SET ";

    if(!empty($f_name)){
        $query = $query."`f_name` = '$f_name', ";
    }
    if(!empty($l_name)){
        $query = $query."`l_name` = '$l_name', ";
    }
    if(!empty($image_upload)){
        $query = $query."`user_image` = '$image_upload', ";
    }
    if(!empty($worker_email)){
        $query = $query."`email` = '$worker_email', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($aadhar_no)){
        $query = $query."`aadhar_no` = '$aadhar_no', ";
    }

    $dob = strtotime($dob);
    $dob = date('Y-m-d',$dob);
    $query = $query."`dob` = '$dob', ";

    if(isset($dom) && $dom != '' && $dom != NULL){
        $dom = strtotime($dom);
        $dom = date('Y-m-d',$dom);
        $query = $query."`dom` = '$dom', ";
    }else{
        $dom = NULL;
    }

    $query = $query."`updated_at` = now() WHERE `id` = ".$karyakarta_id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function get_workers_counts($conn){
    $query = "select count(id) as total_users from tbl_users;";
        $value= mysqli_query($conn,$query);
      $result= mysqli_fetch_assoc($value);
    return $result['total_users'];
 }
 function get_complaints_counts($conn){
    $qry = "select count(id) as total_complaints from tbl_complaints;";
        $total_value= mysqli_query($conn,$qry);
      $result= mysqli_fetch_assoc($total_value);
    return $result['total_complaints'];
    

 }
 function get_today_comlaints($conn){

    // date_default_timezone_set("Asia/Calcutta");
    // $dayStartTime = strtotime(date("Y-m-d", time()).' '.'00:00:00');
    $dayStartTime = date("Y-m-d", time());
    $query= "select count(id) as today_complaints from tbl_complaints where created_at >= '$dayStartTime'";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_assoc($total_value);
    return $result['today_complaints'];
}
function get_today_users($conn){

    // date_default_timezone_set("Asia/Calcutta");
    // $dayStartTime = strtotime(date("Y-m-d", time()).' '.'00:00:00');
    $dayStartTime = date("Y-m-d", time());
    $query= "select count(id) as today_users from tbl_users where created_at >= '$dayStartTime'";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_assoc($total_value);
    return $result['today_users'];
}

function add_single_voter_deprecated($conn,$profile_image,$f_name,$l_name,$voter_aadhar,$voter_email,$voter_phone,$voter_dob,$last_complaint){
    if(isset($voter_dob) && $voter_dob != '' && $voter_dob != NULL){
        $voter_dob = strtotime($voter_dob);
        $voter_dob = date('Y-m-d',$voter_dob);
    }else{
        $voter_dob = NULL;
    }
    if(isset($last_complaint) && $last_complaint != '' && $last_complaint != NULL){
        $last_complaint = strtotime($last_complaint);
        $last_complaint = date('Y-m-d',$last_complaint);
    }else{
        $last_complaint = NULL;
    }
    $query = "INSERT INTO `tbl_users` (`f_name`, `l_name`, `user_image`, `aadhar_no`, `email_id`, `ph_no`, `dob`, `last_complaint`, `created_at`) VALUES ('$f_name', '$l_name', '$profile_image', '$voter_aadhar','$voter_email', $voter_phone, '$voter_dob', '$last_complaint', now())";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function add_single_voter($conn,$file_id,$loksabha,$vidhansabha,$booth_no,$house_no,$voter_name_hin,$voter_age,$father_husband_name_hin,$gender_hin,$ward_hin,$cast_hin,$phone_no,$pesha_hin,$voter_name_en,$father_husband_name_en,$gender_en,$ward_en,$cast_en,$pesha_en){
    $query = "INSERT INTO `tbl_voters` (`file_id`, `loksabha`, `vidhansabha`, `booth_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `gender_hin`, `ward_hin`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en`, `created_at`) VALUES ('$file_id','$loksabha','$vidhansabha','$booth_no','$house_no','$voter_name_hin','$voter_age','$father_husband_name_hin','$gender_hin','$ward_hin','$voter_name_en','$father_husband_name_en','$gender_en','$ward_en', now())";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_dept_admin($conn,$admin_id){
    $response = array();
    $query = "SELECT tau.id,tau.f_name, tau.l_name,tau.user_image,tau.email,tbl_department.name,tau.department_id FROM tbl_admin_users as tau JOIN tbl_department ON tbl_department.id=tau.department_id where tbl_department.name != 'Super Admin'";
    $query = isset($admin_id) ? $query." and tau.id = $admin_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);

    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['f_name'] = $value[1];
            $response[$key]['l_name'] = $value[2];
            $response[$key]['user_image'] = $value[3];
            $response[$key]['email'] = $value[4];
            $response[$key]['name'] = $value[5];
            $response[$key]['department_id'] = $value[6];
        }
    }

    if(count($response) > 1 || !isset($admin_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
   
    return $response;
}

function delete_an_admin($conn,$selected_admin){
    $query = "DELETE FROM tbl_admin_users WHERE id = $selected_admin";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function update_dept_admin($conn,$admin_user_id,$profile_image='',$f_name='',$l_name='',$admin_email='',$selected_dept,$update_password){   
    $query = "UPDATE `tbl_admin_users` SET ";

    if(!empty($f_name)){
        $query = $query."`f_name` = '$f_name', ";
    }
    if(!empty($l_name)){
        $query = $query."`l_name` = '$l_name', ";
    }
    if(!empty($profile_image)){
        $query = $query."`user_image` = '$profile_image', ";
    }
    if(!empty($admin_email)){
        $query = $query."`email` = '$admin_email', ";
    }
    if(!empty($selected_dept)){
        $query = $query."`department_id` = '$selected_dept', ";
    }
    if(!empty($update_password)){
        $update_password = md5($update_password);
        $query = $query."`password` = '$update_password', ";
    }

    $query = $query."`updated_at` = now() WHERE `id` = ".$admin_user_id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function get_new_users_stats($conn,$start_date,$end_date)
{
    $query = "SELECT CAST(created_at AS DATE) as created_at, COUNT(id) as total_users FROM `tbl_users` ";
    if(isset($start_date) && isset($end_date)){
        if($start_date != $end_date){
            $query .= "WHERE created_at >= '$start_date' and created_at <= '$end_date'  GROUP BY CAST(created_at AS date)";
        }else{
            $query .= "WHERE created_at LIKE '$start_date%'  GROUP BY CAST(created_at AS date)";
        }
    }else{
        $today = date("Y-m-d");
        $lastWeek = date("Y-m-d", strtotime("-7 days"));
        $query .= "WHERE created_at >= '$lastWeek' and created_at <= '$today'  GROUP BY CAST(created_at AS date)";
    }
    $query_result = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($query_result);
    foreach($result as $key => $value){
        $result[$key][0] = strtotime($result[$key][0])*1000;
        $result[$key][1] = (int)$result[$key][1];
    }
return $result;
}

function get_total_users_stats($conn,$start_date,$end_date)
{
    $query = "SELECT CAST(created_at AS DATE) as created_at_date, (SELECT COUNT(id) FROM `tbl_users` WHERE created_at <= created_at_date) as total_users FROM `tbl_users` ";
    if(isset($start_date) && isset($end_date)){
        if($start_date != $end_date){
            $query .= "WHERE created_at >= '$start_date' and created_at <= '$end_date'  GROUP BY CAST(created_at AS date)";
        }else{
            $query .= "WHERE created_at LIKE '$start_date%'  GROUP BY CAST(created_at AS date)";
        }
    }else{
        $today = date("Y-m-d");
        $lastWeek = date("Y-m-d", strtotime("-7 days"));
        $query .= "WHERE created_at >= '$lastWeek' and created_at <= '$today'  GROUP BY CAST(created_at AS date)";
    }
    $query_result = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($query_result);
    foreach($result as $key => $value){
        $result[$key][0] = strtotime($result[$key][0])*1000;
        $result[$key][1] = (int)$result[$key][1];
    }
return $result;
}

function add_google_map_locations($conn,$loc_name,$loc_latt,$loc_longi){
    $query = "INSERT INTO `google_map_locations` (`location_name`, `latitude`, `longitude`, `created_at`) VALUES ('$loc_name', '$loc_latt', '$loc_longi', now());";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function get_all_marker($conn){
    $response = array();

    $query = "SELECT * FROM google_map_locations ";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['id'] = $value[0];
                $response[$key]['location_name'] = $value[1];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function add_map_stats($conn, $marker, $cast, $total_voter)
{
    $cast = strtolower($cast);

    $isExistQuery = "SELECT count(`id`) AS 'count' FROM `google_map_stats` WHERE `map_id` = '$marker' AND `voters_caste` = '$cast'";
    $isExist = mysqli_query($conn, $isExistQuery);
    $goForUpdate = mysqli_fetch_assoc($isExist)['count'];

    if ($goForUpdate) {
        $query = "UPDATE `google_map_stats` SET `total_voters` = '$total_voter', `updated_at` = now() WHERE `map_id` = '$marker' AND `voters_caste` = '$cast'";

    } else {
        $query = "INSERT INTO `google_map_stats` (`map_id`, `voters_caste`, `total_voters`, `created_at`) VALUES ('$marker', '$cast', '$total_voter', now());";
    }

    try {
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    } catch (Exception $e) {
        // asd($e->getMessage());
    }

    return;
}

function delete_caste_from_map_stats($conn,$caste_id){
    $query = "DELETE FROM google_map_stats WHERE id = $caste_id";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function delete_location_and_stats($conn,$selected_location){
    $query_1 = "DELETE FROM google_map_stats WHERE map_id = $selected_location";
    $query_2 = "DELETE FROM google_map_locations WHERE id = $selected_location";
    try{
        mysqli_query($conn, $query_1);
        mysqli_query($conn, $query_2);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}



function get_all_locations($conn){
    $response_map_locn = array();
    $response_map_stats = array();

    $query = "SELECT id as map_id, location_name, latitude, longitude FROM google_map_locations";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            $response_map_locn[$key][] = $value[1]; // location_name
            $response_map_locn[$key][] = (float)$value[2]; // latitude
            $response_map_locn[$key][] = (float)$value[3]; // longitude

            foreach($value as $innerKey => $innerValue){
                $query_stats = "SELECT voters_caste, total_voters FROM google_map_stats WHERE map_id = '$value[0]'";
                mysqli_set_charset($conn,'utf8');
                $query_result = mysqli_query($conn, $query_stats);
                $result_stats = mysqli_fetch_all($query_result);
                
                foreach($result_stats as $keys => $values){
                    foreach($values as $innerKeys => $innerValues){
                        $response_map_stats[$keys]['voters_caste'] = $values[0];
                        $response_map_stats[$keys]['total_voters'] = $values[1];
                    }
                }
                $response_map_locn[$key][] = $response_map_stats; // stats
                $response_map_stats = array();
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    
    // asd($response_map_locn);
    return $response_map_locn;
}

function get_bjp_vidhansabha_karyakarini($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM bjp_vidhansabha_karyakarini";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_bjp_jila_karyakarini($conn,$selected_jila,$worker_id){
    $response = array();
    $query = "SELECT id,district,designation, name, father_name,age,cast,phone_no,address,active_membership_number,previous_designation,nivasi_mandal,dob,kab_se,kab_tak,status FROM bjp_jila_karyakarini";
    $query = isset($selected_jila) ? $query." where district = '$selected_jila'" : $query;
    // $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
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
    // asd($response);
    return $response;
}

function get_bjp_shakti_kendra($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`, `kram`,`assembly`, `mandal`, `shakti_kendra_name`, `prabhari`, `prabhari_phone_no`, `sanyojak`, `sanyojak_phone_no`, `co_sanyojak`, `co_sanyojak_phone_no`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjp_shakti_kendra`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['kram'] = $value[1];
            $response[$key]['assembly'] = $value[2];
            $response[$key]['mandal'] = $value[3];
            $response[$key]['shakti_kendra_name'] = $value[4];
            $response[$key]['prabhari'] = $value[5];
            $response[$key]['prabhari_phone_no'] = $value[6];
            $response[$key]['sanyojak'] = $value[7];
            $response[$key]['sanyojak_phone_no'] = $value[8];
            $response[$key]['co_sanyojak'] = $value[9];
            $response[$key]['co_sanyojak_phone_no'] = $value[10];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[11]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[12]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[13]));
            $response[$key]['status'] = $value[14];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_bjp_booth_adhyaksh($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`, `kram`,`assembly`, `mandal`, `booth_adhyaksh`, `phone_no`, `booth_no`, `address`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjp_booth_adhyaksh`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['kram'] = $value[1];
            $response[$key]['assembly'] = $value[2];
            $response[$key]['mandal'] = $value[3];
            $response[$key]['booth_adhyaksh'] = $value[4];
            $response[$key]['phone_no'] = $value[5];
            $response[$key]['booth_no'] = $value[6];
            $response[$key]['address'] = $value[7];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[8]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[9]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[10]));
            $response[$key]['status'] = $value[11];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_bjp_mandal_karyakarini($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`,`assembly`, `mandal`, `adhyaksh`, `adhyaksh_phone_no`, `prabhari`, `prabhari_phone_no`, `vistarak`, `vistarak_phone_no`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjp_mandal_karyakarini`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['mandal'] = $value[2];
            $response[$key]['adhyaksh'] = $value[3];
            $response[$key]['adhyaksh_phone_no'] = $value[4];
            $response[$key]['prabhari'] = $value[5];
            $response[$key]['prabhari_phone_no'] = $value[6];
            $response[$key]['vistarak'] = $value[7];
            $response[$key]['vistarak_phone_no'] = $value[8];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[9]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[10]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[11]));
            $response[$key]['status'] = $value[12];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function delete_bjp_jila_karyakarini($conn,$record_id){
    $query = "DELETE FROM bjp_jila_karyakarini WHERE id = $record_id";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_kissan($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_kissan` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);

    return;
}

function get_morcha_kissan($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_kissan";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_kissan($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_kissan` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_mahila($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_mahila` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_mahila($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_mahila";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_mahila($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_mahila` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_miniority($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_miniority` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_miniority($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_miniority";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_miniority($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_miniority` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_obc($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_obc` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_obc($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_obc";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_obc($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_obc` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_sc($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_sc` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_sc($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_sc";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_sc($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_sc` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_st($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_st` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_st($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_st";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_st($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_st` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_morcha_yuva($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `morcha_yuva` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_morcha_yuva($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM morcha_yuva";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function update_morcha_yuva($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `morcha_yuva` SET ";

    if(!empty($assembly)){
        $query = $query."`assembly` = '$assembly', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }
    if(!empty($dob)){
        $query = $query."`dob` = '$dob', ";
    }
    if(!empty($kab_se)){
       $query = $query."`kab_se` = '$kab_se', ";
   }
   if(!empty($kab_tak)){
       $query = $query."`kab_tak` = '$kab_tak', ";
   }
   if(!empty($status)){
       $query = $query."`status` = '$status', ";
   }
    
    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_bjp_vidhansabha_karyakarini($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `bjp_vidhansabha_karyakarini` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function get_vidhansabha_karyakarini($conn,$id){
     $response = array();
     $query = "SELECT id,assembly,name,phone_no,dob,kab_se,kab_tak,status FROM bjp_vidhansabha_karyakarini ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['assembly'] = $value[1];
             $response[$key]['name'] = $value[2];
             $response[$key]['phone_no'] = $value[3];
             $response[$key]['dob'] = $value[4];
             $response[$key]['kab_se'] = $value[5];
             $response[$key]['kab_tak'] = $value[6];
             $response[$key]['status'] = $value[7];
             
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_vidhansabha_karyakarini($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjp_vidhansabha_karyakarini` SET ";
 
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($phone_no)){
         $query = $query."`phone_no` = '$phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
 function get_vidhansabha_karyakarini1($conn,$id){
     $response = array();
     $query = "SELECT id,assembly,name,phone_no,dob,kab_se,kab_tak,status FROM bjym_vidhansabha_karyakarini ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['assembly'] = $value[1];
             $response[$key]['name'] = $value[2];
             $response[$key]['phone_no'] = $value[3];
             $response[$key]['dob'] = $value[4];
             $response[$key]['kab_se'] = $value[5];
             $response[$key]['kab_tak'] = $value[6];
             $response[$key]['status'] = $value[7];
             
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_vidhansabha_karyakarini1($conn,$id,$assembly='',$name='',$phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjym_vidhansabha_karyakarini` SET ";
 
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($phone_no)){
         $query = $query."`phone_no` = '$phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
function add_bjp_mandal_karyakarini($conn,$assembly,$mandal,$adhyaksh,$adhyaksh_phone_no,$prabhari,$prabhari_phone_no,$vistarak,$vistarak_phone_no,$dob){

    $query = "INSERT INTO `bjp_mandal_karyakarini` (`assembly`,`mandal`, `adhyaksh`, `adhyaksh_phone_no`, `prabhari`, `prabhari_phone_no`, `vistarak`, `vistarak_phone_no`,`dob`) VALUES ('$assembly','$mandal','$adhyaksh','$adhyaksh_phone_no','$prabhari','$prabhari_phone_no','$vistarak','$vistarak_phone_no',$dob)";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}
function get_mandal_karyakarini($conn,$id){
    echo $response = array();
     $query = "SELECT id,assembly,mandal,adhyaksh,adhyaksh_phone_no,prabhari,prabhari_phone_no,vistarak,vistarak_phone_no,dob,kab_se,kab_tak,status FROM bjp_mandal_karyakarini ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['assembly'] = $value[1];
             $response[$key]['mandal'] = $value[2];
             $response[$key]['adhyaksh'] = $value[3];
             $response[$key]['adhyaksh_phone_no'] = $value[4];
             $response[$key]['prabhari'] = $value[5];
             $response[$key]['prabhari_phone_no'] = $value[6];
             $response[$key]['vistarak'] = $value[7];
             $response[$key]['vistarak_phone_no'] = $value[8];
             $response[$key]['dob'] = $value[9];
             $response[$key]['kab_se'] = $value[10];
             $response[$key]['kab_tak'] = $value[11];
             $response[$key]['status'] = $value[12];
             
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_mandal_karyakarini($conn,$id,$assembly='',$mandal='',$adhyaksh='',$adhyaksh_phone_no='',$prabhari='',$prabhari_phone_no='',$vistarak='',$vistarak_phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjp_mandal_karyakarini` SET ";
 
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($adhyaksh)){
         $query = $query."`adhyaksh` = '$adhyaksh', ";
     }
     if(!empty($adhyaksh_phone_no)){
         $query = $query."`adhyaksh_phone_no` = '$adhyaksh_phone_no', ";
     }
     if(!empty($prabhari)){
         $query = $query."`prabhari` = '$prabhari', ";
     }
     if(!empty($prabhari_phone_no)){
         $query = $query."`prabhari_phone_no` = '$prabhari_phone_no', ";
     }
     if(!empty($vistarak)){
         $query = $query."`vistarak` = '$vistarak', ";
     }     
     if(!empty($vistarak_phone_no)){
         $query = $query."`vistarak_phone_no` = '$vistarak_phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
 function get_mandal_karyakarini1($conn,$id){
    echo $response = array();
     $query = "SELECT id,assembly,mandal,adhyaksh,adhyaksh_phone_no,prabhari,prabhari_phone_no,vistarak,vistarak_phone_no,dob,kab_se,kab_tak,status FROM bjym_mandal_karyakarini ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['assembly'] = $value[1];
             $response[$key]['mandal'] = $value[2];
             $response[$key]['adhyaksh'] = $value[3];
             $response[$key]['adhyaksh_phone_no'] = $value[4];
             $response[$key]['prabhari'] = $value[5];
             $response[$key]['prabhari_phone_no'] = $value[6];
             $response[$key]['vistarak'] = $value[7];
             $response[$key]['vistarak_phone_no'] = $value[8];
             $response[$key]['dob'] = $value[9];
             $response[$key]['kab_se'] = $value[10];
             $response[$key]['kab_tak'] = $value[11];
             $response[$key]['status'] = $value[12];
             
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_mandal_karyakarini1($conn,$id,$assembly='',$mandal='',$adhyaksh='',$adhyaksh_phone_no='',$prabhari='',$prabhari_phone_no='',$vistarak='',$vistarak_phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjym_mandal_karyakarini` SET ";
 
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($adhyaksh)){
         $query = $query."`adhyaksh` = '$adhyaksh', ";
     }
     if(!empty($adhyaksh_phone_no)){
         $query = $query."`adhyaksh_phone_no` = '$adhyaksh_phone_no', ";
     }
     if(!empty($prabhari)){
         $query = $query."`prabhari` = '$prabhari', ";
     }
     if(!empty($prabhari_phone_no)){
         $query = $query."`prabhari_phone_no` = '$prabhari_phone_no', ";
     }
     if(!empty($vistarak)){
         $query = $query."`vistarak` = '$vistarak', ";
     }     
     if(!empty($vistarak_phone_no)){
         $query = $query."`vistarak_phone_no` = '$vistarak_phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }

function add_bjp_shakti_kendra($conn,$kram,$assembly,$mandal,$shakti_kendra_name,$prabhari,$prabhari_phone_no,$sanyojak,$sanyojak_phone_no,$co_sanyojak,$co_sanyojak_phone_no,$dob){

    $query = "INSERT INTO `bjp_shakti_kendra` (`kram`,`assembly`, `mandal`, `shakti_kendra_name`, `prabhari`, `prabhari_phone_no`, `sanyojak`, `sanyojak_phone_no`,`co_sanyojak`,`co_sanyojak_phone_no`,`dob`) VALUES ('$kram','$assembly','$mandal','$shakti_kendra_name','$prabhari','$prabhari_phone_no','$sanyojak','$sanyojak_phone_no','$co_sanyojak','$co_sanyojak_phone_no','$dob')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}
function get_shakti_kendra($conn,$id){
    echo $response = array();
     $query = "SELECT id,kram,assembly,mandal,shakti_kendra_name,prabhari,prabhari_phone_no,sanyojak,sanyojak_phone_no,co_sanyojak,co_sanyojak_phone_no,dob,kab_se,kab_tak,status FROM bjp_shakti_kendra ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['kram'] = $value[1];
             $response[$key]['assembly'] = $value[2];
             $response[$key]['mandal'] = $value[3];
             $response[$key]['shakti_kendra_name'] = $value[4];
             $response[$key]['prabhari'] = $value[5];
             $response[$key]['prabhari_phone_no'] = $value[6];
             $response[$key]['sanyojak'] = $value[7];
             $response[$key]['sanyojak_phone_no'] = $value[8];
             $response[$key]['co_sanyojak'] = $value[9];
             $response[$key]['co_sanyojak_phone_no'] = $value[10];
             $response[$key]['dob'] = $value[11];
             $response[$key]['kab_se'] = $value[12];
             $response[$key]['kab_tak'] = $value[13];
             $response[$key]['status'] = $value[14];
            
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_shakti_kendrai($conn,$id,$kram='',$assembly='',$mandal='',$shakti_kendra_name='',$prabhari='',$prabhari_phone_no='',$sanyojak='',$sanyojak_phone_no='',$co_sanyojak='',$co_sanyojak_phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjp_shakti_kendra` SET ";
 
     if(!empty($kram)){
         $query = $query."`kram` = '$kram', ";
     }
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($shakti_kendra_name)){
         $query = $query."`shakti_kendra_name` = '$shakti_kendra_name', ";
     }
     if(!empty($prabhari)){
         $query = $query."`prabhari` = '$prabhari', ";
     }
     if(!empty($prabhari_phone_no)){
         $query = $query."`prabhari_phone_no` = '$prabhari_phone_no', ";
     }
     if(!empty($sanyojak)){
         $query = $query."`sanyojak` = '$sanyojak', ";
     }
     if(!empty($admin_email)){
         $query = $query."`email` = '$admin_email', ";
     }
     if(!empty($sanyojak_phone_no)){
         $query = $query."`sanyojak_phone_no` = '$sanyojak_phone_no', ";
     }
     if(!empty($co_sanyojak)){
         $query = $query."`co_sanyojak` = '$co_sanyojak', ";
     }
     if(!empty($co_sanyojak_phone_no)){
         $query = $query."`co_sanyojak_phone_no` = '$co_sanyojak_phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
 
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
 function get_shakti_kendra1($conn,$id){
    echo $response = array();
     $query = "SELECT id,kram,assembly,mandal,shakti_kendra_name,prabhari,prabhari_phone_no,sanyojak,sanyojak_phone_no,co_sanyojak,co_sanyojak_phone_no,dob,kab_se,kab_tak,status FROM bjym_shakti_kendra ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['kram'] = $value[1];
             $response[$key]['assembly'] = $value[2];
             $response[$key]['mandal'] = $value[3];
             $response[$key]['shakti_kendra_name'] = $value[4];
             $response[$key]['prabhari'] = $value[5];
             $response[$key]['prabhari_phone_no'] = $value[6];
             $response[$key]['sanyojak'] = $value[7];
             $response[$key]['sanyojak_phone_no'] = $value[8];
             $response[$key]['co_sanyojak'] = $value[9];
             $response[$key]['co_sanyojak_phone_no'] = $value[10];
             $response[$key]['dob'] = $value[11];
             $response[$key]['kab_se'] = $value[12];
             $response[$key]['kab_tak'] = $value[13];
             $response[$key]['status'] = $value[14];
            
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_shakti_kendrai1($conn,$id,$kram='',$assembly='',$mandal='',$shakti_kendra_name='',$prabhari='',$prabhari_phone_no='',$sanyojak='',$sanyojak_phone_no='',$co_sanyojak='',$co_sanyojak_phone_no='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjym_shakti_kendra` SET ";
 
     if(!empty($kram)){
         $query = $query."`kram` = '$kram', ";
     }
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($shakti_kendra_name)){
         $query = $query."`shakti_kendra_name` = '$shakti_kendra_name', ";
     }
     if(!empty($prabhari)){
         $query = $query."`prabhari` = '$prabhari', ";
     }
     if(!empty($prabhari_phone_no)){
         $query = $query."`prabhari_phone_no` = '$prabhari_phone_no', ";
     }
     if(!empty($sanyojak)){
         $query = $query."`sanyojak` = '$sanyojak', ";
     }
     if(!empty($admin_email)){
         $query = $query."`email` = '$admin_email', ";
     }
     if(!empty($sanyojak_phone_no)){
         $query = $query."`sanyojak_phone_no` = '$sanyojak_phone_no', ";
     }
     if(!empty($co_sanyojak)){
         $query = $query."`co_sanyojak` = '$co_sanyojak', ";
     }
     if(!empty($co_sanyojak_phone_no)){
         $query = $query."`co_sanyojak_phone_no` = '$co_sanyojak_phone_no', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
 
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }

function add_bjp_jila_karyakarini($conn,$district,$designation,$name,$father_name,$age,$cast,$phone_no,$address,$active_membership_number,$previous_designation,$nivasi_mandal,$karyakarini_DOB){

    $query = "INSERT INTO `bjp_jila_karyakarini` (`district`,`designation`, `name`, `father_name`, `age`, `cast`, `phone_no`, `address`,`active_membership_number`,`previous_designation`,`nivasi_mandal`,`dob`) VALUES ('$district','$designation','$name','$father_name','$age','$cast','$phone_no','$address','$active_membership_number','$previous_designation','$nivasi_mandal','$karyakarini_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_jila_karyakarini($conn,$id){
   echo $response = array();
    $query = "SELECT id,district,designation,name,father_name,age,cast,phone_no,address,active_membership_number,previous_designation,nivasi_mandal,dob,kab_se,kab_tak,status FROM bjp_jila_karyakarini ";
    $query = isset($id) ? $query." WHERE id = $id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);

    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
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
            $response[$key]['kab_se'] = $value[13];
            $response[$key]['kab_tak'] = $value[14];
            $response[$key]['status'] = $value[15];
        }
    }

    if(count($response) > 1 || !isset($id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
   
    return $response;
}

function update_bjp_jila_karyakarini($conn,$id,$district='',$designation='',$name='',$father_name='',$age='',$cast='',$phone_no='',$address='',$active_membership_number='',$previous_designation='',$nivasi_mandal='',$karyakarini_DOB='',$kab_se='',$kab_tak='',$status=''){   
    $query = "UPDATE `bjp_jila_karyakarini` SET ";

    if(!empty($district)){
        $query = $query."`district` = '$district', ";
    }
    if(!empty($designation)){
        $query = $query."`designation` = '$designation', ";
    }
    if(!empty($name)){
        $query = $query."`name` = '$name', ";
    }
    if(!empty($father_name)){
        $query = $query."`father_name` = '$father_name', ";
    }
    if(!empty($age)){
        $query = $query."`age` = '$age', ";
    }
    if(!empty($cast)){
        $query = $query."`cast` = '$cast', ";
    }
    if(!empty($phone_no)){
        $query = $query."`phone_no` = '$phone_no', ";
    }    
    if(!empty($address)){
        $query = $query."`address` = '$address', ";
    }
    if(!empty($active_membership_number)){
        $query = $query."`active_membership_number` = '$active_membership_number', ";
    }
    if(!empty($previous_designation)){
        $query = $query."`previous_designation` = '$previous_designation', ";
    }
    if(!empty($nivasi_mandal)){
        $query = $query."`nivasi_mandal` = '$nivasi_mandal', ";
    }
    if(!empty($karyakarini_DOB)){
        $query = $query."`dob` = '$karyakarini_DOB', ";
    }
    if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
    

    $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function get_jila_karyakarini1($conn,$id){
    echo $response = array();
     $query = "SELECT id,district,designation,name,father_name,age,cast,phone_no,address,active_membership_number,previous_designation,nivasi_mandal,dob,kab_se,kab_tak,status FROM bjym_jila_karyakarini ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
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
             $response[$key]['kab_se'] = $value[13];
             $response[$key]['kab_tak'] = $value[14];
             $response[$key]['status'] = $value[15];
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_bjym_jila_karyakarini($conn,$id,$district='',$designation='',$name='',$father_name='',$age='',$cast='',$phone_no='',$address='',$active_membership_number='',$previous_designation='',$nivasi_mandal='',$karyakarini_DOB='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjym_jila_karyakarini` SET ";
 
     if(!empty($district)){
         $query = $query."`district` = '$district', ";
     }
     if(!empty($designation)){
         $query = $query."`designation` = '$designation', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($father_name)){
         $query = $query."`father_name` = '$father_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($cast)){
         $query = $query."`cast` = '$cast', ";
     }
     if(!empty($phone_no)){
         $query = $query."`phone_no` = '$phone_no', ";
     }    
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($active_membership_number)){
         $query = $query."`active_membership_number` = '$active_membership_number', ";
     }
     if(!empty($previous_designation)){
         $query = $query."`previous_designation` = '$previous_designation', ";
     }
     if(!empty($nivasi_mandal)){
         $query = $query."`nivasi_mandal` = '$nivasi_mandal', ";
     }
     if(!empty($karyakarini_DOB)){
         $query = $query."`dob` = '$karyakarini_DOB', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
 
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }

function add_bjp_booth_adhyaksh($conn,$kram,$assembly,$mandal,$booth_adhyaksh,$phone_no,$booth_no,$address,$dob){

    $query = "INSERT INTO `bjp_booth_adhyaksh`(`kram`,`assembly`, `mandal`, `booth_adhyaksh`, `phone_no`, `booth_no`, `address`,`dob`) VALUES ('$kram','$assembly','$mandal','$booth_adhyaksh','$phone_no','$booth_no','$address','$dob')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_booth_adhyaksh($conn,$id){
    echo $response = array();
     $query = "SELECT id,kram,assembly,mandal,booth_adhyaksh,phone_no,booth_no,address,dob,kab_se,kab_tak,status FROM bjp_booth_adhyaksh ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['kram'] = $value[1];
             $response[$key]['assembly'] = $value[2];
             $response[$key]['mandal'] = $value[3];
             $response[$key]['booth_adhyaksh'] = $value[4];
             $response[$key]['phone_no'] = $value[5];
             $response[$key]['booth_no'] = $value[6];
             $response[$key]['address'] = $value[7];
             $response[$key]['dob'] = $value[8];
             $response[$key]['kab_se'] = $value[9];
             $response[$key]['kab_tak'] = $value[10];
             $response[$key]['status'] = $value[11];
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_booth_adhyaksh($conn,$id,$kram='',$assembly='',$mandal='',$booth_adhyaksh='',$phone_no='',$booth_no='',$address='',$dob='',$kab_se='',$kab_tak='',$status=''){   
     $query = "UPDATE `bjp_booth_adhyaksh` SET ";
 
     if(!empty($kram)){
        $query = $query."`kram` = '$kram', ";
    }
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($booth_adhyaksh)){
         $query = $query."`booth_adhyaksh` = '$booth_adhyaksh', ";
     }
     if(!empty($phone_no)){
         $query = $query."`phone_no` = '$phone_no', ";
     }
     if(!empty($booth_no)){
         $query = $query."`booth_no` = '$booth_no', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }
     
     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
 function get_booth_adhyaksh1($conn,$id){
    echo $response = array();
     $query = "SELECT id,kram,assembly,mandal,booth_adhyaksh,phone_no,booth_no,address,dob,kab_se,kab_tak,status FROM bjym_booth_adhyaksh ";
     $query = isset($id) ? $query." WHERE id = $id" : $query;
     mysqli_set_charset($conn,'utf8');
     $value= mysqli_query($conn,$query);
     $result= mysqli_fetch_all($value);
 
     foreach($result as $key => $value){
         foreach($value as $innerKey => $innerValue){
             $response[$key]['kram'] = $value[1];
             $response[$key]['assembly'] = $value[2];
             $response[$key]['mandal'] = $value[3];
             $response[$key]['booth_adhyaksh'] = $value[4];
             $response[$key]['phone_no'] = $value[5];
             $response[$key]['booth_no'] = $value[6];
             $response[$key]['address'] = $value[7];
             $response[$key]['dob'] = $value[8];
             $response[$key]['kab_se'] = $value[9];
             $response[$key]['kab_tak'] = $value[10];
             $response[$key]['status'] = $value[11];
            
         }
     }
 
     if(count($response) > 1 || !isset($id)){
         // Do Nothing..
     }else{
         $response = $response[0];
     }
    
     return $response;
 }
 
 function update_booth_adhyaksh1($conn,$id,$kram='',$assembly='',$mandal='',$booth_adhyaksh='',$phone_no='',$booth_no='',$address='',$dob='',$kab_se='',$kab_tak='',$status=''){
     $query = "UPDATE `bjym_booth_adhyaksh` SET ";

     if(!empty($kram)){
         $query = $query."`kram` = '$kram', ";
     }
     if(!empty($assembly)){
         $query = $query."`assembly` = '$assembly', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($booth_adhyaksh)){
         $query = $query."`booth_adhyaksh` = '$booth_adhyaksh', ";
     }
     if(!empty($phone_no)){
         $query = $query."`phone_no` = '$phone_no', ";
     }
     if(!empty($booth_no)){
         $query = $query."`booth_no` = '$booth_no', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }

function get_bjym_vidhansabha_karyakarini($conn,$worker_id){
    $response = array();
    $query = "SELECT id,assembly, name, phone_no,dob,kab_se,kab_tak,status FROM bjym_vidhansabha_karyakarini";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['name'] = $value[2];
            $response[$key]['phone_no'] = $value[3];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[4]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[5]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[6]));
            $response[$key]['status'] = $value[7];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}


function get_bjym_jila_karyakarini($conn,$selected_jila,$worker_id){
    $response = array();
    $query = "SELECT id,district,designation, name, father_name,age,cast,phone_no,address,active_membership_number,previous_designation,nivasi_mandal,dob,kab_se,kab_tak,status FROM bjym_jila_karyakarini";
    $query = isset($selected_jila) ? $query." where district = '$selected_jila'" : $query;
    // $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
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
    // asd($response);
    return $response;
}

function get_bjym_shakti_kendra($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`, `kram`,`assembly`, `mandal`, `shakti_kendra_name`, `prabhari`, `prabhari_phone_no`, `sanyojak`, `sanyojak_phone_no`, `co_sanyojak`, `co_sanyojak_phone_no`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjym_shakti_kendra`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['kram'] = $value[1];
            $response[$key]['assembly'] = $value[2];
            $response[$key]['mandal'] = $value[3];
            $response[$key]['shakti_kendra_name'] = $value[4];
            $response[$key]['prabhari'] = $value[5];
            $response[$key]['prabhari_phone_no'] = $value[6];
            $response[$key]['sanyojak'] = $value[7];
            $response[$key]['sanyojak_phone_no'] = $value[8];
            $response[$key]['co_sanyojak'] = $value[9];
            $response[$key]['co_sanyojak_phone_no'] = $value[10];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[11]));
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[11]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[12]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[13]));
            $response[$key]['status'] = $value[14];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_bjym_booth_adhyaksh($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`, `kram`,`assembly`, `mandal`, `booth_adhyaksh`, `phone_no`, `booth_no`, `address`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjym_booth_adhyaksh`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['kram'] = $value[1];
            $response[$key]['assembly'] = $value[2];
            $response[$key]['mandal'] = $value[3];
            $response[$key]['booth_adhyaksh'] = $value[4];
            $response[$key]['phone_no'] = $value[5];
            $response[$key]['booth_no'] = $value[6];
            $response[$key]['address'] = $value[7];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[8]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[9]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[10]));
            $response[$key]['status'] = $value[11];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_bjym_mandal_karyakarini($conn,$worker_id){
    $response = array();
    $query = "SELECT `id`,`assembly`, `mandal`, `adhyaksh`, `adhyaksh_phone_no`, `prabhari`, `prabhari_phone_no`, `vistarak`, `vistarak_phone_no`,`dob`,`kab_se`,`kab_tak`,`status` FROM `bjym_mandal_karyakarini`";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['assembly'] = $value[1];
            $response[$key]['mandal'] = $value[2];
            $response[$key]['adhyaksh'] = $value[3];
            $response[$key]['adhyaksh_phone_no'] = $value[4];
            $response[$key]['prabhari'] = $value[5];
            $response[$key]['prabhari_phone_no'] = $value[6];
            $response[$key]['vistarak'] = $value[7];
            $response[$key]['vistarak_phone_no'] = $value[8];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[9]));
            $response[$key]['kab_se'] = date('d-M-Y',strtotime($value[10]));
            $response[$key]['kab_tak'] = date('d-M-Y',strtotime($value[11]));
            $response[$key]['status'] = $value[12];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function hard_delete($conn,$record_id,$table){

    $query = "DELETE FROM $table WHERE id = $record_id";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function delete_bjym_jila_karyakarini($conn,$record_id){
    $query = "DELETE FROM bjym_jila_karyakarini WHERE id = $record_id";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}

function add_bjym_vidhansabha_karyakarini($conn,$assembly,$name,$phone_no,$vidhansabha_DOB){

    $query = "INSERT INTO `bjym_vidhansabha_karyakarini` (`assembly`,`name`, `phone_no`,`dob`) VALUES ('$assembly','$name','$phone_no','$vidhansabha_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function add_bjym_jila_karyakarini($conn,$district,$designation,$name,$father_name,$age,$cast,$phone_no,$address,$active_membership_number,$previous_designation,$nivasi_mandal,$karyakarini_DOB){

    $query = "INSERT INTO `bjym_jila_karyakarini` (`district`,`designation`, `name`, `father_name`, `age`, `cast`, `phone_no`, `address`,`active_membership_number`,`previous_designation`,`nivasi_mandal`,`dob`) VALUES ('$district','$designation','$name','$father_name','$age','$cast','$phone_no','$address','$active_membership_number','$previous_designation','$nivasi_mandal','$karyakarini_DOB')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}
function add_bjym_mandal_karyakarini($conn,$assembly,$mandal,$adhyaksh,$adhyaksh_phone_no,$prabhari,$prabhari_phone_no,$vistarak,$vistarak_phone_no,$dob){

    $query = "INSERT INTO `bjym_mandal_karyakarini` (`assembly`,`mandal`, `adhyaksh`, `adhyaksh_phone_no`, `prabhari`, `prabhari_phone_no`, `vistarak`, `vistarak_phone_no`,`dob`) VALUES ('$assembly','$mandal','$adhyaksh','$adhyaksh_phone_no','$prabhari','$prabhari_phone_no','$vistarak','$vistarak_phone_no',$dob)";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function add_bjym_shakti_kendra($conn,$kram,$assembly,$mandal,$shakti_kendra_name,$prabhari,$prabhari_phone_no,$sanyojak,$sanyojak_phone_no,$co_sanyojak,$co_sanyojak_phone_no,$dob){

    $query = "INSERT INTO `bjym_shakti_kendra` (`kram`,`assembly`, `mandal`, `shakti_kendra_name`, `prabhari`, `prabhari_phone_no`, `sanyojak`, `sanyojak_phone_no`,`co_sanyojak`,`co_sanyojak_phone_no`,`dob`) VALUES ('$kram','$assembly','$mandal','$shakti_kendra_name','$prabhari','$prabhari_phone_no','$sanyojak','$sanyojak_phone_no','$co_sanyojak','$co_sanyojak_phone_no','$dob')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
  
    return;
}

function add_bjym_booth_adhyaksh($conn,$kram,$assembly,$mandal,$booth_adhyaksh,$phone_no,$booth_no,$address,$dob){

    $query = "INSERT INTO `bjym_booth_adhyaksh`(`kram`,`assembly`, `mandal`, `booth_adhyaksh`, `phone_no`, `booth_no`, `address`,`dob`) VALUES ('$kram','$assembly','$mandal','$booth_adhyaksh','$phone_no','$booth_no','$address','$dob')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    return;
}

function get_all_jilas_for_bjp_jila_karyakarini($conn){
    $response = array();
    $query = "SELECT `district` FROM `bjp_jila_karyakarini` GROUP BY `district`";
    try{
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['name'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }

    return $response;
}

function get_all_jilas_for_bjym_jila_karyakarini($conn){
    $response = array();
    $query = "SELECT `district` FROM `bjym_jila_karyakarini` GROUP BY `district`";
    try{
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['name'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }

    return $response;
}
function get_voter_details($conn,$voter_id){
    $response = array();
    $query = "SELECT booth_no, voter_name_hin, father_husband_name_hin, house_no FROM tbl_voters";
    $query = isset($voter_id) ? $query." where id = $voter_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['booth_no'] = $value[0];
            $response[$key]['voter_name_hin'] = $value[1];
            $response[$key]['father_husband_name_hin'] = $value[2];
            $response[$key]['house_no'] = $value[3];
      
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    return $response;
}

function  add_voter_survey($conn,$voter_id,$pesha,$mobile_no,$whatsapp_no,$pramukh_mudde,$rating_current_govt,$voted_2019_loksabha,$voted_2018_vidhansabha,$vote_reason_2018,$vichardhahra,$corona,$active_karyakarta,$vidhansabha_2023,$caste,$caste_categories){
    $query = "INSERT INTO `tbl_voter_survey` (`voter_id`, `pesha`, `mobile_no`, `whatsapp_no`, `pramukh_mudde`, `rating_current_govt`, `voted_2019_loksabha`, `voted_2018_vidhansabha`, `vote_reason_2018`, `vichardhahra`, `corona`, `active_karyakarta`, `vidhansabha_2023`, `caste`, `caste_categories`,`created_at`) VALUES ('$voter_id','$pesha','$mobile_no','$whatsapp_no','$pramukh_mudde','$rating_current_govt','$voted_2019_loksabha','$voted_2018_vidhansabha','$vote_reason_2018','$vichardhahra','$corona','$active_karyakarta','$vidhansabha_2023','$caste','$caste_categories', now())";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    header("Location: userbase.php");
}

function get_wards_names($conn,$booth_no){
    $query = "SELECT `ward_hin` FROM `tbl_voters` WHERE `booth_no` = $booth_no GROUP BY `ward_hin` ORDER BY `id` ASC";
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    $response = array();

    foreach($result as $key => $value){
        $response[$key] = $value[0];
    }

    return $response;
}

function track_field_workers($conn,$assignedLoksabha){
    $response_map_locn = array();
    // asd($assignedLoksabha);
    $query = "SELECT tbl_survilance.username, tbl_survilance.latitude, tbl_survilance.longitude, tbl_admin_users.user_image FROM tbl_survilance JOIN tbl_admin_users ON tbl_admin_users.username = tbl_survilance.username WHERE tbl_admin_users.department_id = 6";
    
    if(isset($assignedLoksabha) && $assignedLoksabha != '' && $assignedLoksabha != NULL){
        $query .= ' AND tbl_admin_users.assigned_loksabha = '."'".$assignedLoksabha."'";
    }

    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            $response_map_locn[$key][] = $value[0]; // username
            $response_map_locn[$key][] = (float)$value[1]; // latitude
            $response_map_locn[$key][] = (float)$value[2]; // longitude
            $response_map_locn[$key][] = $value[3]; // user image
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }    
    // asd($response_map_locn);
    return $response_map_locn;
}

function add_loksabha($loksabha_name,$conn){
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $query = "INSERT INTO tbl_loksabha (loksabha) VALUES ('$loksabha_name')";
        try{
            mysqli_set_charset($conn,'utf8');
            mysqli_query($conn, $query);           
        }catch(Exception $e){
            //asd($e->getMessage());
        }
        return;
    }
}

function addLoksabha($loksabha_name,$conn){
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $query = "INSERT INTO tbl_loksabha (loksabha) VALUES ('$loksabha_name')";
        try{
            mysqli_set_charset($conn,'utf8');
            mysqli_query($conn, $query);   
        }catch(Exception $e){
            //asd($e->getMessage());
        }
        header("Location:loksabha_add.php");
    }
}
function addMandal($conn,$selected_vidhansabha,$mandal){
    $query = "INSERT INTO tbl_mandal (vidhansabha,mandal,created_at) VALUES ('$selected_vidhansabha','$mandal', now())";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    header("Location:mandal_add.php");
}
function addPanchayat($conn,$selected_mandal,$panchayat,$boothRange){
    $query = "INSERT INTO tbl_panchayat (mandal,panchayat,booth_range,created_at) VALUES ('$selected_mandal','$panchayat','$boothRange', now())";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    header("Location:panchayat_add.php");
}

function addVidhansabha($conn,$selected_loksabha,$vidhansabha){
    $query = "INSERT INTO tbl_vidhansabha (loksabha,vidhansabha,created_at) VALUES ('$selected_loksabha','$vidhansabha', now())";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    header("Location:vidhansabha_add.php");
}



function add_vidhansabha($conn,$selected_loksabha,$vidhansabha){
    $query = "INSERT INTO tbl_loksabha (loksabha,vidhansabha) VALUES ('$selected_loksabha','$vidhansabha')";
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;
}
function get_all_loksabha($conn){
    $query = "SELECT loksabha FROM tbl_loksabha GROUP BY loksabha";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['loksabha'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function getAllVidhansabha($conn){
    $query = "SELECT vidhansabha FROM tbl_vidhansabha GROUP BY vidhansabha HAVING vidhansabha != 'NULL'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['vidhansabha'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function get_all_vidhansabha($conn){
    $query = "SELECT vidhansabha FROM tbl_loksabha GROUP BY vidhansabha HAVING vidhansabha != 'NULL'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['vidhansabha'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}
function getAllMandal($conn){
    $query = "SELECT mandal FROM tbl_mandal GROUP BY mandal HAVING mandal != 'NULL'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['mandal'] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function delete_loksabha($conn,$selected_loksabha_for_delete){
    $query = "DELETE FROM tbl_loksabha WHERE loksabha = '$selected_loksabha_for_delete'";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;

}

function delete_vidhansabha($conn,$selected_vidhansabha_for_delete){
    $query = "DELETE FROM tbl_loksabha WHERE vidhansabha = '$selected_vidhansabha_for_delete'";
    try{
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return;

}

function getDepartmentIds($conn){
    $response = array();
    $query = "SELECT `id` FROM `tbl_department` WHERE `name` != 'Super Admin'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key] = $value[0];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function getLoksabhaOfLoggedInUser($conn,$user_id){
    $response = array();
    $query = "SELECT assigned_loksabha FROM tbl_admin_users WHERE id="."'".$user_id."'";
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $response = mysqli_fetch_assoc($query_result)['assigned_loksabha'];
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function delete_voters_data($conn,$id){
    $query1 = "DELETE FROM `tbl_voters` WHERE `id` = $id";
    $query2 = "DELETE FROM `tbl_voter_survey` WHERE `voter_id` = $id";
    $query3 = "DELETE FROM `tbl_mumbai_voter_survey` WHERE `voter_id` = $id";

    mysqli_query($conn, $query1);
    mysqli_query($conn, $query2);
    mysqli_query($conn, $query3);
    return;
}

function addQuestion($conn,$selected_loksabha,$vidhansabha,$question,$question_option){
 
   $option = !empty($question_option[0]) ? "$question_option[0]" : 'NULL';
   $option1 = !empty($question_option[1]) ? "$question_option[1]" : 'NULL';
   $option2 = !empty($question_option[2]) ? "$question_option[2]" : 'NULL';
   $option3 = !empty($question_option[3]) ? "$question_option[3]" : 'NULL';
   $option4 = !empty($question_option[4]) ? "$question_option[4]" : 'NULL';
   $option5 = !empty($question_option[5]) ? "$question_option[5]" : 'NULL';
   $option6 = !empty($question_option[6]) ? "$question_option[6]" : 'NULL';
   $option7 = !empty($question_option[7]) ? "$question_option[7]" : 'NULL';
   $option8 = !empty($question_option[8]) ? "$question_option[8]" : 'NULL';
   $option9 = !empty($question_option[9]) ? "$question_option[9]" : 'NULL';
    $query = "INSERT INTO tbl_survey_questions(loksabha,vidhansabha,question,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,created_at) VALUES ('$selected_loksabha','$vidhansabha','$question','$option','$option1','$option2','$option3','$option4','$option5','$option6','$option7','$option8','$option9',now())";
//    print_r($query);
//    die;
    try{
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    header("Location:questions.php");
}

function get_surveyers_stats($conn,$loksabha,$start_date,$end_date){
    $response = array();
    $start_date = date("Y-m-d H:i:s", strtotime($start_date . ' ' . '00:00:00'));
    $end_date = date("Y-m-d H:i:s", strtotime($end_date . ' ' . '23:59:59'));

    if(isset($loksabha) && $loksabha != '' && $loksabha != NULL){
        if($loksabha == 'चित्तौड़गढ़'){
            $query = "SELECT surveyed_by, SUM(total_surveys) AS 'total_surveys', MAX(data.created_at) AS 'last_surveyed_at', MIN(data.fcreated_at) AS 'first_surveyed_at'
                    FROM
                    (SELECT `surveyed_by`, count(id) as 'total_surveys', MAX(`created_at`) AS created_at, MIN(`created_at`) AS fcreated_at
                    FROM `tbl_voter_survey`
                    WHERE `created_at` >= '$start_date' AND `created_at` <= '$end_date'
                    GROUP BY `surveyed_by`) AS data
                    GROUP BY surveyed_by";
        }else if($loksabha == 'मुंबई साउथ'){
            $query = "SELECT surveyed_by, SUM(total_surveys) AS 'total_surveys', MAX(data.created_at) AS 'last_surveyed_at', MIN(data.fcreated_at) AS 'first_surveyed_at'
                    FROM
                    (SELECT `surveyed_by`, count(id) as 'total_surveys', MAX(`created_at`) AS created_at, MIN(`created_at`) AS fcreated_at
                    FROM `tbl_mumbai_voter_survey`
                    WHERE `created_at` >= '$start_date' AND `created_at` <= '$end_date'
                    GROUP BY `surveyed_by`) AS data
                    GROUP BY surveyed_by";
        }else{
            return;
        }
    }else{
        $query = "SELECT surveyed_by, SUM(total_surveys) AS 'total_surveys', MAX(data.created_at) AS 'last_surveyed_at', MIN(data.fcreated_at) AS 'first_surveyed_at'
        FROM
        (SELECT `surveyed_by`, count(id) as 'total_surveys', MAX(`created_at`) AS created_at, MIN(`created_at`) AS fcreated_at
        FROM `tbl_voter_survey`
        WHERE `created_at` >= '$start_date' AND `created_at` <= '$end_date'
        GROUP BY `surveyed_by`
        UNION
        SELECT `surveyed_by`, count(id) as 'total_surveys', MAX(`created_at`) AS created_at, MIN(`created_at`) AS fcreated_at
        FROM `tbl_mumbai_voter_survey`
        WHERE `created_at` >= '$start_date' AND `created_at` <= '$end_date'
        GROUP BY `surveyed_by`) AS data
        GROUP BY surveyed_by";
    }
// asd($query);
    try{
        mysqli_set_charset($conn,'utf8');
        $query_result = mysqli_query($conn, $query);
        $result = mysqli_fetch_all($query_result);
        foreach($result as $key => $value){
            foreach($value as $innerKey => $innerValue){
                $response[$key]['surveyed_by'] = $value[0];
                $response[$key]['total_surveys'] = $value[1];
                $response[$key]['last_surveyed_at'] = $value[2];
                $response[$key]['first_surveyed_at'] = $value[3];
            }
        }
    }catch(Exception $e){
        //asd($e->getMessage());
    }
    return $response;
}

function export_surveyed_userbase($conn,$filter_pesha,$booth_no,$assignedLoksabha ,$filter_loksabha,$filter_mandal,$filter_panchayat,$filter_boothRange,$filter_category,$filter_caste,$filter_ward,$filter_pramukh_mudde,$filter_mojuda_sarkaar,$filter_2019_loksabha,$filter_2018_vidhansabha,$filter_partyVsCandidate,$filter_vichardhara,$filter_corona,$filter_local_candidate,$filter_2023_vidhansabha,$filter_ageGroup){
    $response = array();

    $response_data = array();
    $queryForVoterIds = "SELECT `id` FROM `tbl_voters` ";

    if(!empty($filter_loksabha)){
        $loksabha = $filter_loksabha;
        $queryForVoterIds .= "WHERE loksabha = '$loksabha' ";
    }    
    if(!empty($filter_vidhansabha)){
        $vidhansabha = $filter_vidhansabha;
        $queryForVoterIds .= "AND vidhansabha = '$vidhansabha' ";
    }
    if(!empty($filter_boothRange)){
        $booth_range = $filter_boothRange;
        $booth_range = explode('~',$booth_range);
        $queryForVoterIds .= "AND `booth_no` BETWEEN $booth_range[0] AND $booth_range[1] ";
    }else if(!empty($filter_mandal) && empty($filter_panchayat)){
        $mandal  = $filter_mandal;
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
    }else if(!empty($filter_panchayat)){
        $panchayat  = $filter_panchayat;
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
    if(!empty($filter_ward)){
        $ward = $filter_ward;
        $queryForVoterIds .= "AND ward_hin LIKE '%$ward%' ";
    }
    if(!empty($filter_gender)){
        $gender = $filter_gender;
        $queryForVoterIds .= "AND gender_hin = '$gender' ";
    }
    if(!empty($filter_ageGroup)){
        $ageGroup = $filter_ageGroup;
        $ageGroup = explode('~',$ageGroup);
        $queryForVoterIds .= "AND `voter_age` BETWEEN $ageGroup[0] AND $ageGroup[1] ";
    }

    $queryForVoterIds .= " AND is_surveyed = 1";

    $total_value= mysqli_query($conn,$queryForVoterIds);
    $result= mysqli_fetch_all($total_value);

    foreach($result as $key => $value){
        $response_data[] = $value[0];
    }
    $voter_ids = implode(', ', $response_data);;

    $query = "SELECT tbl_voters.id AS 'id', `file_id`, `loksabha`, `vidhansabha`, `booth_no`, `section_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `sambandh`, `gender_hin`, `ward_hin`, `id_no`, `poling_station_hin`, `poling_station_en`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en`, `pesha`, `mobile_no`, `whatsapp_no`, `pramukh_mudde`, `rating_current_govt`, `voted_2019_loksabha`, `voted_2018_vidhansabha`, `vote_reason_2018`, `vichardhahra`, `corona`, `active_karyakarta`, `vidhansabha_2023`, `caste`, `caste_categories`, `surveyed_by`, tbl_voter_survey.created_at AS surveyed_at  FROM tbl_voter_survey INNER JOIN tbl_voters ON tbl_voter_survey.voter_id = tbl_voters.id";
    
    // if(isset($booth) && $booth != '' && $booth != NULL){
    //     $query .= ' WHERE tbl_voters.booth_no = '."'".$booth."' ORDER BY tbl_voter_survey.created_at DESC LIMIT 2000";
    // }else{
	// $query .= ' ORDER BY tbl_voter_survey.created_at DESC LIMIT 2000';
	// }
    $query .= " WHERE tbl_voters.is_surveyed = 1";
    if(isset($voter_ids) && $voter_ids != '' && $voter_ids != NULL){
        $query .= " AND tbl_voters.id IN ($voter_ids)";
    }
    if(isset($filter_category) && $filter_category != '' && $filter_category != NULL){
        $query .= " AND tbl_voter_survey.caste_categories LIKE '%".$filter_category."%'";
    }
    if(isset($filter_caste) && $filter_caste != '' && $filter_caste != NULL){
        $query .= " AND tbl_voter_survey.caste LIKE '%".trim($filter_caste)."%'";
    }
    if(isset($filter_pesha) && $filter_pesha != '' && $filter_pesha != NULL){
        $query .= " AND tbl_voter_survey.pesha LIKE '%".trim($filter_pesha)."%'";
    }
    if(isset($filter_pramukh_mudde) && $filter_pramukh_mudde != '' && $filter_pramukh_mudde != NULL){
        $query .= " AND tbl_voter_survey.pramukh_mudde LIKE '%".trim($filter_pramukh_mudde)."%'";
    }
    if(isset($filter_mojuda_sarkaar) && $filter_mojuda_sarkaar != '' && $filter_mojuda_sarkaar != NULL){
        $query .= " AND tbl_voter_survey.rating_current_govt LIKE '%".trim($filter_mojuda_sarkaar)."%'";
    }
    if(isset($filter_2019_loksabha) && $filter_2019_loksabha != '' && $filter_2019_loksabha != NULL){
        $query .= " AND tbl_voter_survey.voted_2019_loksabha LIKE '%".trim($filter_2019_loksabha)."%'";
    }
    if(isset($filter_2018_vidhansabha) && $filter_2018_vidhansabha != '' && $filter_2018_vidhansabha != NULL){
        $query .= " AND tbl_voter_survey.voted_2018_vidhansabha LIKE '%".trim($filter_2018_vidhansabha)."%'";
    }
    if(isset($filter_partyVsCandidate) && $filter_partyVsCandidate != '' && $filter_partyVsCandidate != NULL){
        $query .= " AND tbl_voter_survey.vote_reason_2018 LIKE '%".trim($filter_partyVsCandidate)."%'";
    }
    if(isset($filter_vichardhara) && $filter_vichardhara != '' && $filter_vichardhara != NULL){
        $query .= " AND tbl_voter_survey.vichardhahra LIKE '%".trim($filter_vichardhara)."%'";
    }
    if(isset($filter_corona) && $filter_corona != '' && $filter_corona != NULL){
        $query .= " AND tbl_voter_survey.corona LIKE '%".trim($filter_corona)."%'";
    }
    if(isset($filter_local_candidate) && $filter_local_candidate != '' && $filter_local_candidate != NULL){
        $query .= " AND tbl_voter_survey.active_karyakarta LIKE '%".trim($filter_local_candidate)."%'";
    }
    if(isset($filter_2023_vidhansabha) && $filter_2023_vidhansabha != '' && $filter_2023_vidhansabha != NULL){
        $query .= " AND tbl_voter_survey.vidhansabha_2023 LIKE '%".trim($filter_2023_vidhansabha)."%'";
    }
    
    $query .= ' ORDER BY tbl_voter_survey.created_at DESC LIMIT 2000';
    mysqli_set_charset($conn,'utf8');
    $value = mysqli_query($conn,$query);
    $result = mysqli_fetch_all($value);
    $i = 1;

    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['s_no'] = $i;
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
        $i++;
    }
    return $response;
}

function get_mandal_panchayat_datasets($conn,$loksabha){
    $response = array();
    $query = "SELECT `id`, `loksabha`, `vidhansabha`, `mandal`, `panchayat`, `booth_range` FROM `tbl_mandal_panchayat_mapping`";
    if($loksabha != '')
        $query = isset($loksabha) ? $query." where loksabha = '$loksabha'" : $query;
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
            $response[$key]['booth_range'] = $value[5];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function delete_mandal_panchayat_datasets($conn,$id){
    $query = "DELETE FROM `tbl_mandal_panchayat_mapping` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_todaySurveyed($conn){
    $dayStartTime = date("Y-m-d", time());
    $query= "select count(id) as todaySurveyed from tbl_voter_survey where created_at >= '$dayStartTime'";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_assoc($total_value);
    return $result['todaySurveyed'];
}

function get_totalSurveyed($conn){
    $query= "select count(id) as totalSurveyed from tbl_voter_survey";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_assoc($total_value);
    return $result['totalSurveyed'];
}

function get_activeSurveyors($conn){
    $dayStartTime = date("Y-m-d", time());
    $query= "SELECT surveyed_by FROM tbl_voter_survey WHERE created_at >= '$dayStartTime' GROUP BY surveyed_by";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    $result['activeSurveyors'] = count($result);
    return $result['activeSurveyors'];
}

function get_totalSurveyors($conn){
    $query= "SELECT surveyed_by FROM tbl_voter_survey GROUP BY surveyed_by";
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    $result['totalSurveyors'] = count($result);
    return $result['totalSurveyors'];
}

function get_category_list($conn){
    $query = "SELECT caste_categories FROM tbl_voter_survey GROUP BY caste_categories";
    mysqli_set_charset($conn,'utf8');
    $value = mysqli_query($conn,$query);
    $result = mysqli_fetch_all($value);
    return $result;
}

function get_voter_ids_for_analytics($conn,$filters){
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
    return implode(', ', $response);;
}

function get_g1($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT rating_current_govt, COUNT(id) as rating FROM tbl_voter_survey WHERE rating_current_govt != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY rating_current_govt";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        $i++;
    }

    return $percentage;
}

function get_g2($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT pesha, COUNT(id) as rating FROM tbl_voter_survey WHERE pesha != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY pesha";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }

    $midResponse = array();

    foreach($response as $k1 => $v1){
        switch($k1){
            case strpos($k1,'किसान'):
                $midResponse['किसान'] += $v1; 
                break;
            case strpos($k1,'व्यवसाय'):
                $midResponse['व्यवसाय'] += $v1; 
                break;
            case strpos($k1,'नौकरी'):
                $midResponse['नौकरी'] += $v1; 
                break;
            case strpos($k1,'मजदूर'):
                $midResponse['मजदूर'] += $v1; 
                break;
            case strpos($k1,'विद्यार्थी'):
                $midResponse['विद्यार्थी'] += $v1; 
                break;
            case strpos($k1,'बेरोजगार'):
                $midResponse['बेरोजगार'] += $v1; 
                break;
            case strpos($k1,'गृहणी'):
                $midResponse['गृहणी'] += $v1; 
                break;
            case strpos($k1,'रिटायर्ड'):
                $midResponse['रिटायर्ड'] += $v1; 
                break;
            case strpos($k1,'कोई कार्य नही कर रहे'):
                $midResponse['कोई कार्य नही कर रहे'] += $v1; 
                break;
        }
    }

    foreach($midResponse as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        $i++;
    }
    
    return $percentage;
}

function get_g3($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT pramukh_mudde, COUNT(id) as rating FROM tbl_voter_survey WHERE pramukh_mudde != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY pramukh_mudde";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    $midResponse = array();

    foreach($response as $k1 => $v1){
        switch($k1){
            case strpos($k1,'सड़क'):
                $midResponse['सड़क'] += $v1; 
                break;
            case strpos($k1,'बिजली'):
                $midResponse['बिजली'] += $v1; 
                break;
            case strpos($k1,'पानी सप्लाई'):
                $midResponse['पानी सप्लाई'] += $v1; 
                break;
            case strpos($k1,'रोज़गार'):
                $midResponse['रोज़गार'] += $v1; 
                break;
            case strpos($k1,'शिक्षा'):
                $midResponse['शिक्षा'] += $v1; 
                break;
            case strpos($k1,'स्वास्थ्य सुविधएँ'):
                $midResponse['स्वास्थ्य सुविधएँ'] += $v1; 
                break;
            case strpos($k1,'जल निकासी'):
                $midResponse['जल निकासी'] += $v1; 
                break;
            case strpos($k1,'स्ट्रीट लाइट'):
                $midResponse['स्ट्रीट लाइट'] += $v1; 
                break;
            case strpos($k1,'कचरा प्रबंधन'):
                $midResponse['कचरा प्रबंधन'] += $v1; 
                break;
            case strpos($k1,'लोकल ट्रांसपोर्ट'):
                $midResponse['लोकल ट्रांसपोर्ट'] += $v1; 
                break;
        }
    }

    foreach($midResponse as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 2){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        $i++;
    }

    return $percentage;
}

function get_g4($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT voted_2019_loksabha, COUNT(id) as rating FROM tbl_voter_survey WHERE voted_2019_loksabha != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY voted_2019_loksabha";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        if($i == 0){
            $percentage[$i]['color'] = "#41b4e1";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#138808";
        }
        if($i == 2){
            $percentage[$i]['color'] = "#ffff00";
        }
        if($i == 3){
            $percentage[$i]['color'] = "#22409a";
        }
        
        if($i == 4){
            $percentage[$i]['color'] = "#ff9933";
        }
        $i++;
    }

    return $percentage;
}

function get_g5($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT voted_2018_vidhansabha, COUNT(id) as rating FROM tbl_voter_survey WHERE voted_2018_vidhansabha != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY voted_2018_vidhansabha";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];;
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        if($i == 0){
            $percentage[$i]['color'] = "#41b4e1";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#138808";
        }
        if($i == 2){
            $percentage[$i]['color'] = "#ffff00";
        }
        if($i == 3){
            $percentage[$i]['color'] = "#22409a";
        }
        if($i == 4){
            $percentage[$i]['color'] = "#ff9933";
        }
        $i++;
    }

    return $percentage;
}

function get_g6($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT vote_reason_2018, COUNT(id) as rating FROM tbl_voter_survey WHERE vote_reason_2018 != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY vote_reason_2018";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        $i++;
    }

    return $percentage;
}

function get_g7($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT vichardhahra, COUNT(id) as rating FROM tbl_voter_survey WHERE vichardhahra != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY vichardhahra";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        $i++;
    }

    return $percentage;
}

function get_g8($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT corona, COUNT(id) as rating FROM tbl_voter_survey WHERE corona != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY corona";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        if($i == 0){
            $percentage[$i]['color'] = "#41b4e1";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#138808";
        }
        if($i == 2){
            $percentage[$i]['color'] = "#ffff00";
        }
        if($i == 3){
            $percentage[$i]['color'] = "#22409a";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#ff9933";
        }
        $i++;
    }

    return $percentage;
}

function get_g9($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();

    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT active_karyakarta, COUNT(id) as rating FROM tbl_voter_survey WHERE active_karyakarta != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY active_karyakarta";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        if($i == 0){
            $percentage[$i]['color'] = "#41b4e1";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#138808";
        }
        if($i == 2){
            $percentage[$i]['color'] = "#ffff00";
        }
        if($i == 3){
            $percentage[$i]['color'] = "#22409a";
        }
        if($i == 4){
            $percentage[$i]['color'] = "#ff9933";
        }
        $i++;
    }

    return $percentage;
}

function get_g10($conn,$filters){
    $percentage = array();
    $sum = 0;
    $i=0;
    $voter_ids = array();
    
    if(count($filters) > 0){
        $voter_ids = get_voter_ids_for_analytics($conn,$filters);
    }

    $query = "SELECT vidhansabha_2023, COUNT(id) as rating FROM tbl_voter_survey WHERE vidhansabha_2023 != '' ";

    if(count($filters) > 0){
        $query .= "AND voter_id IN ($voter_ids) ";
    }
    if(!empty($filters['category'])){
        $category = $filters['category'];
        $query .= "AND caste_categories = '$category' ";
    }
    if(!empty($filters['caste'])){
        $caste = $filters['caste'];
        $query .= "AND caste = '$caste' ";
    }
    $query .= "GROUP BY vidhansabha_2023";

    mysqli_set_charset($conn,'utf8');
    $total_value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($total_value);
    foreach($result as $key => $value){
        $response[$value[0]] = $value[1];
        $sum += $value[1];
    }
    
    foreach($response as $key => $value){
        $percentage[$i]['name'] = $key;
        $percentage[$i]['y'] = ($value/$sum)*100;

        if($i == 0){
            $percentage[$i]['selected'] = true;
            $percentage[$i]['sliced'] = true;
        }
        if($i == 0){
            $percentage[$i]['color'] = "#41b4e1";
        }
        if($i == 1){
            $percentage[$i]['color'] = "#138808";
        }
        if($i == 2){
            $percentage[$i]['color'] = "#ffff00";
        }
        if($i == 3){
            $percentage[$i]['color'] = "#22409a";
        }
        if($i == 4){
            $percentage[$i]['color'] = "#ff9933";
        }
        $i++;
    }

    return $percentage;
}

function add_sms($conn,$sms_type,$sms){

    $query = "INSERT INTO `sms` (`sms_type`,`sms`) VALUES ('$sms_type','$sms')";
    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);

    return;
}

function get_sms($conn,$sms_id){
    $response = array();
    $query = "SELECT id, sms_type, sms FROM sms";
    $query = isset($sms_id) ? $query." where id = $sms_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['id'] = $value[0];
            $response[$key]['sms_type'] = $value[1];
            $response[$key]['sms'] = $value[2];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}

function get_asha_worker($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_asha_worker";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
    // asd($response);
    return $response;
}
function update_asha_worker($conn,$id,$loksabha='',$vidhansabha='',$mandal='',$panchayat='',$booth='',$name='',$fathers_name='',$age='',$caste='',$mobile='',$address='',$dob='',$kab_Se='',$kab_tak='',$status=''){
     $query = "UPDATE `tbl_asha_worker` SET ";

     if(!empty($loksabha)){
         $query = $query."`loksabha` = '$loksabha', ";
     }
     if(!empty($vidhansabha)){
         $query = $query."`vidhansabha` = '$vidhansabha', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($panchayat)){
         $query = $query."`panchayat` = '$panchayat', ";
     }
     if(!empty($booth)){
         $query = $query."`booth` = '$booth', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($fathers_name)){
         $query = $query."`fathers_name` = '$fathers_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($caste)){
         $query = $query."`caste` = '$caste', ";
     }
     if(!empty($mobile)){
         $query = $query."`mobile` = '$mobile', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
function delete_asha_worker($conn,$id){
    $query = "DELETE FROM `tbl_asha_worker` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_anm($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_anm";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
    // asd($response);
    return $response;
}
function update_anm($conn,$id,$loksabha='',$vidhansabha='',$mandal='',$panchayat='',$booth='',$name='',$fathers_name='',$age='',$caste='',$mobile='',$address='',$dob='',$kab_Se='',$kab_tak='',$status=''){
     $query = "UPDATE `tbl_anm` SET ";

     if(!empty($loksabha)){
         $query = $query."`loksabha` = '$loksabha', ";
     }
     if(!empty($vidhansabha)){
         $query = $query."`vidhansabha` = '$vidhansabha', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($panchayat)){
         $query = $query."`panchayat` = '$panchayat', ";
     }
     if(!empty($booth)){
         $query = $query."`booth` = '$booth', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($fathers_name)){
         $query = $query."`fathers_name` = '$fathers_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($caste)){
         $query = $query."`caste` = '$caste', ";
     }
     if(!empty($mobile)){
         $query = $query."`mobile` = '$mobile', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
function delete_anm($conn,$id){
    $query = "DELETE FROM `tbl_anm` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_blo($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_blo";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
    // asd($response);
    return $response;
}
function update_blo($conn,$id,$loksabha='',$vidhansabha='',$mandal='',$panchayat='',$booth='',$name='',$fathers_name='',$age='',$caste='',$mobile='',$address='',$dob='',$kab_Se='',$kab_tak='',$status=''){
     $query = "UPDATE `tbl_blo` SET ";

     if(!empty($loksabha)){
         $query = $query."`loksabha` = '$loksabha', ";
     }
     if(!empty($vidhansabha)){
         $query = $query."`vidhansabha` = '$vidhansabha', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($panchayat)){
         $query = $query."`panchayat` = '$panchayat', ";
     }
     if(!empty($booth)){
         $query = $query."`booth` = '$booth', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($fathers_name)){
         $query = $query."`fathers_name` = '$fathers_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($caste)){
         $query = $query."`caste` = '$caste', ";
     }
     if(!empty($mobile)){
         $query = $query."`mobile` = '$mobile', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
function delete_blo($conn,$id){
    $query = "DELETE FROM `tbl_blo` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}
function update_sarpanch_candidate($conn,$id,$loksabha='',$vidhansabha='',$mandal='',$panchayat='',$booth='',$name='',$fathers_name='',$age='',$caste='',$mobile='',$address='',$dob='',$kab_Se='',$kab_tak='',$status=''){
     $query = "UPDATE `tbl_sarpanch_candidate` SET ";

     if(!empty($loksabha)){
         $query = $query."`loksabha` = '$loksabha', ";
     }
     if(!empty($vidhansabha)){
         $query = $query."`vidhansabha` = '$vidhansabha', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($panchayat)){
         $query = $query."`panchayat` = '$panchayat', ";
     }
     if(!empty($booth)){
         $query = $query."`booth` = '$booth', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($fathers_name)){
         $query = $query."`fathers_name` = '$fathers_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($caste)){
         $query = $query."`caste` = '$caste', ";
     }
     if(!empty($mobile)){
         $query = $query."`mobile` = '$mobile', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }

function get_news_reporter($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_news_reporter";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
    // asd($response);
    return $response;
}
function update_news_reporter($conn,$id,$loksabha='',$vidhansabha='',$mandal='',$panchayat='',$booth='',$name='',$fathers_name='',$age='',$caste='',$mobile='',$address='',$dob='',$kab_Se='',$kab_tak='',$status=''){
     $query = "UPDATE `tbl_news_reporter` SET ";

     if(!empty($loksabha)){
         $query = $query."`loksabha` = '$loksabha', ";
     }
     if(!empty($vidhansabha)){
         $query = $query."`vidhansabha` = '$vidhansabha', ";
     }
     if(!empty($mandal)){
         $query = $query."`mandal` = '$mandal', ";
     }
     if(!empty($panchayat)){
         $query = $query."`panchayat` = '$panchayat', ";
     }
     if(!empty($booth)){
         $query = $query."`booth` = '$booth', ";
     }
     if(!empty($name)){
         $query = $query."`name` = '$name', ";
     }
     if(!empty($fathers_name)){
         $query = $query."`fathers_name` = '$fathers_name', ";
     }
     if(!empty($age)){
         $query = $query."`age` = '$age', ";
     }
     if(!empty($caste)){
         $query = $query."`caste` = '$caste', ";
     }
     if(!empty($mobile)){
         $query = $query."`mobile` = '$mobile', ";
     }
     if(!empty($address)){
         $query = $query."`address` = '$address', ";
     }
     if(!empty($dob)){
         $query = $query."`dob` = '$dob', ";
     }
     if(!empty($kab_se)){
        $query = $query."`kab_se` = '$kab_se', ";
    }
    if(!empty($kab_tak)){
        $query = $query."`kab_tak` = '$kab_tak', ";
    }
    if(!empty($status)){
        $query = $query."`status` = '$status', ";
    }

     $query = $query."`updated_at` = now() WHERE `id` = ".$id.";";
     try{
         mysqli_set_charset($conn,'utf8');
         mysqli_query($conn, $query);
     }catch(Exception $e){
         //asd($e->getMessage());
     }
     return;
 }
function delete_news_reporter($conn,$id){
    $query = "DELETE FROM `tbl_news_reporter` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_sarpanch_candidate($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, address, dob, kab_se, kab_tak, status FROM tbl_sarpanch_candidate";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
    // asd($response);
    return $response;
}

function delete_sarpanch_candidate($conn,$id){
    $query = "DELETE FROM `tbl_sarpanch_candidate` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_others_member($conn,$worker_id){
    $response = array();
    $query = "SELECT id, loksabha, vidhansabha, mandal, panchayat, booth, name, fathers_name, age, caste, mobile, news_paper_channel, address, dob FROM tbl_others_member";
    $query = isset($worker_id) ? $query." where id = $worker_id" : $query;
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
            $response[$key]['news_paper_channel'] = $value[11];
            $response[$key]['address'] = $value[12];
            $response[$key]['dob'] = date('d-M-Y',strtotime($value[13]));
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    // asd($response);
    return $response;
}
function delete_others_member($conn,$id){
    $query = "DELETE FROM `tbl_others_member` WHERE `id` = $id";
    mysqli_query($conn, $query);
    return;
}

function get_survey_details($conn,$voter_id){
    $response = array();
    $query = "SELECT booth_no, voter_name_hin, father_husband_name_hin, house_no, pesha, mobile_no, whatsapp_no, pramukh_mudde, rating_current_govt, voted_2019_loksabha, voted_2018_vidhansabha, vote_reason_2018, vichardhahra, corona, active_karyakarta, vidhansabha_2023, caste, caste_categories FROM tbl_voters AS tv JOIN tbl_voter_survey AS tvs ON tv.id = tvs.voter_id";
    $query = isset($voter_id) ? $query." where tv.id = $voter_id" : $query;
    mysqli_set_charset($conn,'utf8');
    $value= mysqli_query($conn,$query);
    $result= mysqli_fetch_all($value);
    foreach($result as $key => $value){
        foreach($value as $innerKey => $innerValue){
            $response[$key]['booth_no'] = $value[0];
            $response[$key]['voter_name_hin'] = $value[1];
            $response[$key]['father_husband_name_hin'] = $value[2];
            $response[$key]['house_no'] = $value[3];
            $response[$key]['pesha'] = $value[4];
            $response[$key]['mobile_no'] = $value[5];
            $response[$key]['whatsapp_no'] = $value[6];
            $response[$key]['pramukh_mudde'] = $value[7];
            $response[$key]['rating_current_govt'] = $value[8];
            $response[$key]['voted_2019_loksabha'] = $value[9];
            $response[$key]['voted_2018_vidhansabha'] = $value[10];
            $response[$key]['vote_reason_2018'] = $value[11];
            $response[$key]['vichardhahra'] = $value[12];
            $response[$key]['corona'] = $value[13];
            $response[$key]['active_karyakarta'] = $value[14];
            $response[$key]['vidhansabha_2023'] = $value[15];
            $response[$key]['caste'] = $value[16];
            $response[$key]['caste_categories'] = $value[17];
        }
    }
    if(count($response) > 1 || !isset($worker_id)){
        // Do Nothing..
    }else{
        $response = $response[0];
    }
    return $response;
}

function  update_voter_survey($conn,$voter_id,$pesha,$mobile_no,$whatsapp_no,$pramukh_mudde,$rating_current_govt,$voted_2019_loksabha,$voted_2018_vidhansabha,$vote_reason_2018,$vichardhahra,$corona,$active_karyakarta,$vidhansabha_2023,$caste,$caste_categories){

    $pesha = implode(',',$pesha);
    $vichardhahra = implode(',',$vichardhahra);
    $pramukh_mudde = implode(',',$pramukh_mudde);

    $query = "UPDATE `tbl_voter_survey` SET 
        `pesha`	=	'$pesha',
        `mobile_no`	=	'$mobile_no',
        `whatsapp_no`	=	'$whatsapp_no',
        `pramukh_mudde`	=	'$pramukh_mudde',
        `rating_current_govt`	=	'$rating_current_govt',
        `voted_2019_loksabha`	=	'$voted_2019_loksabha',
        `voted_2018_vidhansabha`	=	'$voted_2018_vidhansabha',
        `vote_reason_2018`	=	'$vote_reason_2018',
        `vichardhahra`	=	'$vichardhahra',
        `corona`	=	'$corona',
        `active_karyakarta`	=	'$active_karyakarta',
        `vidhansabha_2023`	=	'$vidhansabha_2023',
        `caste`	=	'$caste',
        `caste_categories`	=	'$caste_categories',
        `created_at` = `created_at`,
        `updated_at`	=	now()
     WHERE `voter_id` = $voter_id";

    mysqli_set_charset($conn,'utf8');
    mysqli_query($conn, $query);
    header("Location: update_voters_survey.php?id=$voter_id");
}

function get_mandal_list($conn,$loksabha){
    $query = "SELECT mandal FROM `tbl_mandal_panchayat_mapping` WHERE `loksabha` = '$loksabha' GROUP BY mandal";

    mysqli_set_charset($conn,'utf8');
    $value = mysqli_query($conn,$query);
    $result = mysqli_fetch_all($value);

    return $result;
}

?>
