<?php

	class PayPal_IPN {
		
		function infotuts_ipn($im_debut_ipn) {

			define('SSL_P_URL', 'https://www.paypal.com/cgi-bin/webscr');
			define('SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
			$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			if (!preg_match('/paypal\.com$/', $hostname)) {
				$ipn_status = 'Validation post isn\'t from PayPal';
				if ($im_debut_ipn == true) {
					// mail test
				}

				return false;
			}

		  // parse the paypal URL
			$paypal_url = ($_REQUEST['test_ipn'] == 1) ? SSL_SAND_URL : SSL_P_URL;
			$url_parsed = parse_url($paypal_url);
			
			$post_string = '';
			foreach ($_REQUEST as $field => $value) {
				$post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';
			}
			$post_string.="cmd=_notify-validate"; // append ipn command
			// get the correct paypal url to post request to
			$paypal_mode_status = $im_debut_ipn; //get_option('im_sabdbox_mode');
			if ($paypal_mode_status == true)
				$fp = fsockopen('ssl://www.sandbox.paypal.com', "443", $err_num, $err_str, 60);
			else
				$fp = fsockopen('ssl://www.paypal.com', "443", $err_num, $err_str, 60);

			$ipn_response = '';

			if (!$fp) {
			// could not open the connection.  If loggin is on, the error message
			// will be in the log.
						$ipn_status = "fsockopen error no. $err_num: $err_str";
						if ($im_debut_ipn == true) {
							echo 'fsockopen fail';
						}
						return false;
					} else {
			// Post the data back to paypal
						fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");
						fputs($fp, "Host: $url_parsed[host]\r\n");
						fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
						fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");
						fputs($fp, "Connection: close\r\n\r\n");
						fputs($fp, $post_string . "\r\n\r\n");

			// loop through the response from the server and append to variable
						while (!feof($fp)) {
							$ipn_response .= fgets($fp, 1024);
						}
						fclose($fp); // close connection
					}
					
			// Invalid IPN transaction.  Check the $ipn_status and log for details.
			if (!preg_match("/VERIFIED/s", $ipn_response)) {
				$ipn_status = 'IPN Validation Failed';

				if ($im_debut_ipn == true) {
					echo 'Validation fail';
					print_r($_REQUEST);
				}
				return false;
			} else {
				
				$ipn_status = "IPN VERIFIED";
				if ($im_debut_ipn == true) {
					echo 'SUCCESS';
					
					}

				return true;
			}
		}

		function ipn_response($request) {
			
			$im_debut_ipn=true;
			if ($this->infotuts_ipn($im_debut_ipn)) {
				
				// if paypal sends a response code back let's handle it        
				   if ($im_debut_ipn == true) {
					$sub = 'PayPal IPN Debug Email Main';
					$msg = print_r($request, true);
					$aname = 'infotuts';
				  //mail send
				}

				// process the membership since paypal gave us a valid +
				//$this->insert_data($request);
				$Url = 'http://www.howlik.com/en/sendcertificates';
				$this->curl_fetch($Url);
			}
		}
		
		function curl_fetch($Url, $refUrl='') {
			
			if (!function_exists('curl_init')){ die('Sorry cURL is not installed!'); }
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $Url);
			if($refUrl!='') {
				
				curl_setopt($ch, CURLOPT_REFERER, $refUrl);
			}
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/4.0");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}

		function issetCheck($post,$key) {
			if(isset($post[$key])) {
				$return=$post[$key];
			}
			else {
				$return='';
			}
			return $return;
		}	
		
		function insert_data($request) {
			
			require_once('dbconnect.php');
			
			$post				=	$request;
			
			$item_name			=	$this->issetCheck($post,'item_name');
			$amount				=	$this->issetCheck($post,'mc_gross');
			$currency			=	$this->issetCheck($post,'mc_currency');
			$payer_email		=	$this->issetCheck($post,'payer_email');
			$first_name			=	$this->issetCheck($post,'first_name');
			$last_name			=	$this->issetCheck($post,'last_name');
			$country			=	$this->issetCheck($post,'residence_country');
			$txn_id				=	$this->issetCheck($post,'txn_id');
			$txn_type			=	$this->issetCheck($post,'txn_type');
			$payment_status		=	$this->issetCheck($post,'payment_status');
			$payment_type		=	$this->issetCheck($post,'payment_type');
			$payer_id			=	$this->issetCheck($post,'payer_id');
			$create_date		=	date('Y-m-d H:i:s');
			$payment_date		=	date('Y-m-d H:i:s');
			
			/*if(isset($_GET['id']) && $_GET['id'] > 0) {
				
				$id		=	$_GET['id'];
				$sql	=	"SELECT * FROM paypal_log WHERE id = '".$id."'";
				if(isset($sql) && count($sql) > 0) {
					
					$val 	=	mysqli_query($con,$sql);
					$row	=	mysqli_fetch_assoc($val);
					$set	=	unserialize($row["pl_details"]);
					
					if(count($set) > 0) {
						
						$gift_id	=	0;
						$count		=	$set[gift_quantity];
						$total		=	$set[gift_quantity] * $set[gift_amount];
						$gift		=	mysqli_query($con,"INSERT INTO gift_certificates (biz_id,user_id,total_quantity,each_price,total_price,active) 
										VALUES ('". $set[biz_id] ."','". $set[sender_id] ."','". $set[gift_quantity] ."','". $set[gift_amount] ."','".$total."',1)");
						
						$gift_id 	=	mysqli_insert_id($con);
						
						if(isset($gift_id) && $gift_id > 0) {
							
							if(!empty($count)) {
				
								for($i=0;$i<=$count-1;$i++) {
									
									$gift_code 	=	time().''.$i;
									$user		=	mysqli_query($con,"INSERT INTO gift_recipients (biz_id,gift_id,gift_code,recipient_name,recipient_email,recipient_message,sender_name,sender_id,active) 
													VALUES ('". $set[biz_id] ."','". $gift_id ."','". $gift_code ."','". $set[recipient_name][$i] ."','". $set[recipient_email][$i] ."','". $set[recipient_message][$i] ."','". $set[sender_name][$i] ."','". $set[sender_id] ."',1)");
									
									$to			=	$set[recipient_name][$i];
									$subject	=	$set[recipient_message][$i];
									$body		=	"A Gift Coupon was successfully recieved\n";
									@mail($too, $sub, $con);
								}
							}
						}
						
					}
				}
			mysqli_close($con);	*/
			}
		}
	}
	
	$obj 		=	New PayPal_IPN();
	$obj->ipn_response($_REQUEST);
	
	$subject 	=	'Instant Payment Notification';
	$to 		=	$_REQUEST[payer_email];    //  your email
	$body		=	"An instant payment notification was successfully recieved\n";
	$body 		.=	"from ".$_REQUEST[payer_email]."on ".date('Y-m-d G:i:s', time());
	//@mail($to, $subject, $body);
	
?>