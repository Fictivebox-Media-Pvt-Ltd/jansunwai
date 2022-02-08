<?php
if(isset($_POST['submit'])){   
       $phone1 = $_POST['mobile'];
       $sms = $_POST['sms'];
       //print_r($phone1);
       $len = count($phone1);
    //echo $len;
    for($i=0; $i < $len; $i++ ){
         $phone1[$i] . "<br>";
        /*MESSAGE CODE*/
    $sender = "HJHALA";
        
	$user = "TusharParashar";

	$pass = "123456";
	
	/* Multiple mobiles numbers separated by comma */
	$phone = $phone1;
	/* Sender ID,While using route4 sender id should be 6 characters long. */
	$sender = $sender;
	/* Your message to send, Add URL encoding here. */
	
	$text=urlencode($sms);

	$priority = "ndnd";

	$stype = "normal";
	
	/* Prepare you post parameters */
	
	
	// Prepare data for POST request
	$data = 'user=' . $user . '&pass=' . $pass . "&sender=" . $sender . "&phone=" . $phone1[$i] . "&text=" . $text . "&priority=" . $priority . "&stype=" . $stype;
 
	// Send the GET request with cURL
	$ch = curl_init('http://bhashsms.com/api/sendmsg.php?' . $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);	
	/* Print error if any */
	if(curl_errno($ch))
	{
		echo 'error:' . curl_error($ch);
	}
	else{
		$array = array(
			"message"    => $response
		);
	}
	curl_close($ch);
	//MESSAGE CODE END
	//print json_encode($array);
    }
    echo "<script>alert('sms sent')</script>";
    echo "<script>window.open('bjym_booth_adhyaksh.php','_self')</script>";
}
?>
