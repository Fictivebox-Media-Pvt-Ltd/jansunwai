<?php
include_once '../configs/database.php';
require "../configs/jwtAuth.php";
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if($jwt){ 
			try {
			$decoded = JWT::decode($jwt,new Key($secret_key, 'HS256'));

      if (isset($_FILES['profile_image']) || isset($_POST['f_name']) || isset($_POST['l_name']) || isset($_POST['admin_email'])) {
        $profile_image = isset($_FILES['profile_image']['name']) ? $_FILES['profile_image']['name'] : '';
        $f_name = isset($_POST['f_name']) ? $_POST['f_name'] : '';
        $l_name = isset($_POST['l_name']) ? $_POST['l_name'] : '';
        $admin_email = isset($_POST['admin_email']) ? $_POST['admin_email'] : '';
    
        $image_upload = '';
        if (!empty($profile_image)) {
            $target_dir = "images/avatar/";
            $image_upload = md5(time().get_client_ip()).'.'.pathinfo($_FILES['profile_image']['name'],PATHINFO_EXTENSION);
            $imageS = $_FILES['profile_image']['size'];
            $ftmp = $_FILES['profile_image']['tmp_name'];
            $store = $target_dir . $image_upload;
            move_uploaded_file($ftmp, $store);
            
        }
        admin_profile_update($conn,$image_upload, $f_name, $l_name, $admin_email);
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