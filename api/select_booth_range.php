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
			if(empty($_POST['panchayat'])){
				echo json_encode(array(
					"message" => "panchayat field is required."
					));
					exit();
			}
			$panchayat = $_POST['panchayat'];
			$query="SELECT DISTINCT booth_range FROM tbl_mandal_panchayat_mapping WHERE panchayat='$panchayat'";
			mysqli_set_charset($conn,'utf8');
			$result=mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
			$rows=mysqli_num_rows($result);
            if($rows >0) {
					$info=array();
					while($row=mysqli_fetch_array($result))
					{
						array_push($info,array(
							'name' => $row['booth_range'],
				));
					}
						echo json_encode(array("success" => true,
						"message" => "Booth Range List",
						"boothRange"=>$info),JSON_UNESCAPED_UNICODE);
				}
				else {
					echo json_encode(array("success" => true,
						"message" => "No data found"),JSON_UNESCAPED_UNICODE);
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