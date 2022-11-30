<?php
include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($jwt){ 
			try {
			$decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));

      if(empty($_POST['user_id'])){
        echo json_encode(array(
            "message" => "user_id field is required."
            ));
            exit();
    }
      $user_id = $_POST['user_id'];
      $voter="SELECT id,f_name,l_name,age,aadhar_no,phone_no,user_image,aadhar_front,aadhar_back FROM tbl_admin_users WHERE id = '$user_id'";
      $result=mysqli_query($conn,$voter) or die("Query problem".mysqli_error($conn));
      $row = mysqli_num_rows($result);
    
       if ($row > 0) {
        $personal_details = array();
          while ($row = mysqli_fetch_array($result)){
             array_push($personal_details, array(
                  'user_id' => $row['id'], 'f_name' => $row['f_name'], 'l_name' => $row['l_name'], 'age' => $row['age'], 'aadhar_no' => $row['aadhar_no'], 'phone_no' => $row['phone_no'], 'user_image' => 'admin/images/avatar/'.$row['user_image'],'aadhar_front' => $row['aadhar_front'],'aadhar_back' => $row['aadhar_back']));
          }

          echo json_encode(array(
            "success" => true,
            "message" => "User profile details",
            "user_profile" => $personal_details), JSON_UNESCAPED_UNICODE);
      }
      else{
        
        echo json_encode(array(
          "success" => true,
          "message" => "Data Not Found"), JSON_UNESCAPED_UNICODE);
      }

    

    
      }
      catch (Exception $e){
        http_response_code(401);
        echo json_encode(array(
        "success" => false,
        "message" => "Access denied.",
        "error" => $e->getMessage()
        ));
      }
  }
?>