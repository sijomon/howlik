<?php

/*	$filename	=	$_SERVER['DOCUMENT_ROOT']."/.env";
    $_ENV		=	array();
	$handle 	=	fopen($filename, "r");
	
	if($handle) 
	{
		while (($line = fgets($handle)) !== false) 
		{
			if( strpos($line,"=") !== false) 
			{
				$var = explode("=",$line);
				$_ENV[$var[0]] = trim($var[1]);
			}
		}
		fclose($handle);
	} 
	else 
	{
		die('error opening .env'); 
	}
	// GET THE DATABASE CREDENTIALS
	
	$servername 	= $_ENV['DB_HOST'];
	$username   	= $_ENV['DB_USERNAME'];
	$password   	= $_ENV['DB_PASSWORD'];
	$dbname			= $_ENV['DB_DATABASE'];

	//echo '<pre>';print_r($servername.''.$username.''.$password.''.$dbname);die;

	$conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
	if($conn->connect_error) {
	     die("Connection failed: " . $conn->connect_error);
    } 
	/* else {
		echo 'Success';
	} */
	/*$device 	= $_POST['device'];
	$user_id 	= $_POST['user_id'];
	if($device ==''){
		die('No device found');
	}
	if($user_id ==''){
		die('No User ID found');
	}*/
	$message_content  				= 'Test Notification';
	$to="cz-Wa83RQ2U:APA91bHVQDy4GA41dPd93SuT4f_rNR1pV5TxiwEqshd0ByvYMdWlPmDS9QY8KsA5sDGQcshWbOLQxBGugB35DL9wg921Vt6qEIY9YEny6va-1KK7MeOpl5f5wo_S9ioLJlxB0Arn3B-UrtBrQQY1Lc0wWcqJ_no06g";
	
	$to_ios="dZ2SH8ieh8c:APA91bGI1C8UbdabivhFu5synKG_MhRh2py-UODi3rYTIEnPunYHkT9a72CAUw2b_mJWeDGz5NQNX1rY0KxE9_vJDppVoQwhebK8dFvIduNge8Buje9MQL4GCaOYjOqPwy1eMyUZMRFRrYHnBztoN3QkewN0v5FuLw";
	
	sendPushNotification($to_ios,$message);
	
	//echo "gggg".$sss;
  //  if ($device == 'android') {
		
		/*$gcm_token = $_POST['gcm_token'];
		$sql = "UPDATE users SET gcm_token='$gcm_token',device='$device' WHERE id='$user_id'";
		if ($conn->query($sql) === TRUE) {
			$arr = array(
				'status' => 'success'
			);
			echo json_encode($arr);
		}
		else {
			$rslt = array(
				'status' => 'failure'
			);
			return json_encode($rslt);
		}*/
	//}
	/*else if ($device == 'ios') {
		
		$ios_token = $_POST['ios_token'];
		$sql = "UPDATE users SET ios_token='$ios_token',device='$device' WHERE id='$user_id'";
		if ($conn->query($sql) === TRUE) {
			$arr = array(
				'status' => 'success'
			);
			echo json_encode($arr);
		}
		else {
			$rslt = array(
				'status' => 'failure'
			);
			return json_encode($rslt);
		}
	}*/
	
	function sendPushNotification($to,$message) {
       
			/*if (!defined('FIREBASE_API_KEY')) {
define('FIREBASE_API_KEY','AAAA46ctEUM:APA91bFXdd3t-Ux6w6DGFYyNrbHMLKLMGJSONXgGKY8B1XiMOEP9wW51dLnZA5WFLTBeiSk_2wQA-FknGmuiFzglv6GDD34PBkJ9ed7jYqRE-9WapeCqV3IEvP-RUrEsb0qM_U6WQ7Jr');
}			*/	

define( 'API_ACCESS_KEY', 'AAAAat5FrqA:APA91bGS1ATAO-Pw-9EFnF2TfzxOwwzPcTnPQUkoeSjKxUu_kddR_SSiSJkhaynvpaoP_dNQOLPDh1qG58PC7451YM3Ai143IcteLNxCs_IUkeYRm_qhUxmMkOWQNHoghbTHyWks4DtYaRQw2vWa5_Ian85DvbpODw');
		
			$url = 'https://fcm.googleapis.com/fcm/send'; 
			
			   
			/*$fields = array(   
				'to' => $to,
				'data' => $message,
			);*/
			
			$fields = array(
					'to'  		=> $to,
					//'aps'		=> $message
					'content_available'=> true,
					'priority'	=> 'high',
					'notification'=> array("title" => 'test', "body"=> $message)
				);
			
			/*$headers = array(
				'Authorization: key=' . "AIzaSyDXm5EoJjiQgazpQgUqRLYYrf8buJ3ks08",
				'Content-Type: application/json'
			);*/
			
			$headers = array(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);
			
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			curl_close($ch);
			$response = json_decode($result, true); 
			echo"<pre>";print_r($response);die; 
			$response = (object)$response;
			$success  = $response->success;
			return $success;
			
			 //print_r(json_encode($message));
			// return $success;
			
		}
   
?>