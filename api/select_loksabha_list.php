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
			$query="SELECT DISTINCT loksabha FROM tbl_mandal_panchayat_mapping";
			mysqli_set_charset($conn,'utf8');
			$result=mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
			$rows=mysqli_num_rows($result);

				if($rows >0) {
					$info=array();
					while($row=mysqli_fetch_array($result))
					{
						array_push($info,array(
					$row['loksabha'],
				));
					}
						echo json_encode(array("success" => true,
						"message" => "loksabha List",
						"loksabha"=>$info),JSON_UNESCAPED_UNICODE);
				}
				else {
					echo json_encode(array("success" => true,
						"message" => "No data found"),JSON_UNESCAPED_UNICODE);
				}

			}
			catch (Exception $e){
				http_response_code(401);
				echo json_encode(array(
				"message" => "Access denied.",
				"error" => $e->getMessage()
				));
			}

	}

?>