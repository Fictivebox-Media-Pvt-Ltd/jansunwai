<?php 
include_once '../configs/database.php';
 
 $response = array();

 $username = $_POST['username'];
 $surveyed_by = $_POST['username'];
 $password = md5($_POST['password']); 
 
 $stmt = $conn->prepare("SELECT id,username, f_name, l_name,aadhar_no,phone_no,email,user_image,(select sum(data.total_survey) as total_survey from ( select count(*) as total_survey from tbl_voter_survey where surveyed_by = ? UNION ALL select count(*) as total_survey from tbl_mumbai_voter_survey where surveyed_by = ? ) data), assigned_loksabha, assigned_vidhansabha FROM tbl_admin_users WHERE username = ? AND password = ?");
 $stmt->bind_param("ssss",$surveyed_by,$surveyed_by,$username, $password);
 
 $stmt->execute();
 
 $stmt->store_result();
 
 if($stmt->num_rows > 0){
 
 $stmt->bind_result($id, $username, $f_name,$l_name,$aadhar,$phone,$email,$user_image,$total_survey,$assigned_loksabha,$assigned_vidhansabha);
 $stmt->fetch();
 
 $user = array(
 'id'=>$id, 
 'username'=>$username, 
 'name'=>$f_name." ".$l_name, 
 'aadhar_no'=>$aadhar,
 'phone_no'=>$phone,
 'email'=>$email,
 'user_image'=>$user_image,
 'total_survey'=>$total_survey,
 'assigned_loksabha'=>$assigned_loksabha,
 'assigned_vidhansabha'=>$assigned_vidhansabha
 );
 
 $response['error'] = false; 
 $response['message'] = 'Login successfull'; 
 $response['user'] = $user; 
 }else{
 $response['error'] = false; 
 $response['message'] = 'Invalid username or password';
 }


 
echo json_encode($response);
