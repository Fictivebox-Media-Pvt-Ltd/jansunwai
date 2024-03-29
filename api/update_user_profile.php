<?php
include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($jwt){ 
			try {
			$decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));

      if(empty($_POST['f_name'])){
				echo json_encode(array(
					"message" => "first name field is required."
					));
					exit();
			}
      if(empty($_POST['l_name'])){
				echo json_encode(array(
					"message" => "last name field is required."
					));
					exit();
			}
      if(empty($_POST['age'])){
				echo json_encode(array(
					"message" => "age field is required."
					));
					exit();
			}
      if(empty($_POST['aadhar_no'])){
				echo json_encode(array(
					"message" => "aadhar no field is required."
					));
					exit();
			}
      if(empty($_POST['phone_no'])){
				echo json_encode(array(
					"message" => "phone no field is required."
					));
					exit();
			}
      // if(empty($_FILES['aadhar_front'])){
			// 	echo json_encode(array(
			// 		"message" => "aadhar front field is required."
			// 		));
			// 		exit();
			// }
      // if(empty($_FILES['aadhar_back'])){
			// 	echo json_encode(array(
			// 		"message" => "aadhar back field is required."
			// 		));
			// 		exit();
			// }
      if (isset($_FILES['user_image']) || isset($_POST['f_name']) || isset($_POST['l_name']) || isset($_POST['admin_email'])) {
      $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
      $userQuery="SELECT user_image,aadhar_front,aadhar_back FROM tbl_admin_users WHERE id = '$user_id'";
      $result=mysqli_query($conn,$userQuery) or die("Query problem".mysqli_error($conn));
      $row = mysqli_num_rows($result);
      
      $user_image = isset($_FILES['user_image']) ? $_FILES['user_image'] : $row['user_image'];
      $f_name = isset($_POST['f_name']) ? $_POST['f_name'] : '';
      $l_name = isset($_POST['l_name']) ? $_POST['l_name'] : '';
      $age = isset($_POST['age']) ? $_POST['age'] : '';
      $aadhar_no = isset($_POST['aadhar_no']) ? $_POST['aadhar_no'] : '';
      $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
      $aadhar_front = isset($_FILES['aadhar_front']) ? $_FILES['aadhar_front'] : $row['aadhar_front'];
      $aadhar_back = isset($_FILES['aadhar_back']) ? $_FILES['aadhar_back'] : $row['aadhar_back'];
    
        if (!empty($user_image)) {
            $target_dir = "../admin/images/avatar/";
            $image_upload = md5(time()).$_FILES['user_image']['name'];
            $imageS = $_FILES['user_image']['size'];
            $ftmp = $_FILES['user_image']['tmp_name'];
            $store = $target_dir . $image_upload;
            $imageUpload ="admin/images/avatar/".$image_upload;
            move_uploaded_file($ftmp, $store);            
        }  
      if (!empty($aadhar_front)) {
            $target_dir = "../admin/images/documents/";
            $aadhar_front = md5(time()).$_FILES['aadhar_front']['name'];
            $imageS = $_FILES['aadhar_front']['size'];
            $ftmp = $_FILES['aadhar_front']['tmp_name'];
            $store = $target_dir . $aadhar_front;
            $aadharFront ="admin/images/documents/".$aadhar_front;
            move_uploaded_file($ftmp, $store);  
      }     
      if (!empty($aadhar_back)) {
            $target_dir = "../admin/images/documents/";
            $aadhar_back = md5(time()).$_FILES['aadhar_back']['name'];
            $imageS = $_FILES['aadhar_back']['size'];
            $ftmp = $_FILES['aadhar_back']['tmp_name'];
            $store = $target_dir . $aadhar_back;
            $aadharBack ="admin/images/documents/".$aadhar_back;
            move_uploaded_file($ftmp, $store);            
        }
      $query = "UPDATE `tbl_admin_users` SET `f_name` = '$f_name',`l_name` = '$l_name',`age` = '$age',`aadhar_no` = '$aadhar_no',`phone_no` = '$phone_no',`user_image` = '$imageUpload',`aadhar_front` = '$aadharFront',`aadhar_back` = '$aadharBack' WHERE `id` = '$user_id'";
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn, $query);
        echo json_encode(array("success" => true,
        "message" => "profile updated successfully"),JSON_UNESCAPED_UNICODE);       
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