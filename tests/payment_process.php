<?php

	if (ini_get('max_execution_time') < 120) 
	{
		set_time_limit(120);
	}

	include($_SERVER['DOCUMENT_ROOT']."/tests/include/paypal.class.php");
	
	$filename	=	$_SERVER['DOCUMENT_ROOT']."/.env";
	
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
	
	$con = mysqli_connect($_ENV['DB_HOST'],$_ENV['DB_USERNAME'],$_ENV['DB_PASSWORD'],$_ENV['DB_DATABASE']);
	// Check connection
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to : " . mysqli_connect_error();
	}
	
	/*if(isset($_GET['pl_id']) && $_GET['pl_id']>0)
	{
		$sql = "select pl_ses from 'paypal_log' where 'pl_id'='" . (int)$_GET['pl_id'] . "'";
		$dataO = $mysql->selectRow ( $sql );
		if(is_array($dataO))
		{
			$ses_array	= unserialize($dataO['pl_ses']);
			if(isset($_GET['action']) && $_GET['action']=='success')
			{
				$_SESSION['receipt'] = $ses_array['receipt'];
			}
		}
	}*/
	
	// if there is not action variable, set the default action of 'process'
	if(empty($_GET['action'])) $_GET['action'] = 'process';	

	$paypalMod 		= 0;
	$product_title	= '';
	if($paypalMod=='1') 
	{
		$paypal_url    = 'https://www.paypal.com/cgi-bin/webscr';
	} 
	else 
	{
		$paypal_url    = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		$paypal_url    = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
	}
	if($_POST['ticket_amount'] != '')
	{
		$total_amount	=	$_POST['ticket_quantity'] * $_POST['ticket_amount'];
		$pay_amount = number_format($total_amount,2);
	}
	//echo $pay_amount;die;
		
	#___________________________________________________ BOF PAYMENT ____________________________________________________________#
	if(isset($_GET['action']))
	{
		
		$action = $_GET['action'];
		$p = new paypal_class;	// initiate an instance of the class
		
		if($paypalMod=='1')
		{
			$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	// paypal url
		} 
		else 
		{
			$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';	// testing paypal url
			$p->paypal_url = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
		}
		
		//$merchantEmail = 'yaagle_1225955852_biz@yahoo.com';
		$merchantEmail = 'yaagle_1225955852_biz@yahoo.com';

		$customer_email = $_POST['usr_email'];
		
		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		
		switch ($action) 
		{
			
			case 'process':	// Process and order...
		  
			
				// There should be no output at this point.  To process the POST data,
				// the submit_paypal_post() function will output all the HTML tags which
				// contains a FORM which is submited instantaneously using the BODY onload
				// attribute.  In other words, don't echo or printf anything when you're
				// going to be calling the submit_paypal_post() function.

				// This is where you would have your form validation  and all that jazz.
				// You would take your POST vars and load them into the class like below,
				// only using the POST values instead of constant string expressions.

				// For example, after ensureing all the POST variables from your custom
				// order form are valid, you might have: //
			  
				if($currency_code=='') {
					$currency_code = 'USD';
				}
				
				$customer_email = 'vineeth';
				$pay_amount = 2; 
				if(!($pay_amount>0)) {
					header("location:index.php");
					exit;
				}
			  
				$serialize_ses	= serialize($_POST);
				$paypal =	mysqli_query($con,"INSERT INTO paypal_log (pl_details, pl_status, pl_response) 
							VALUES ('". $serialize_ses ."','0','0')");
				
				//$pl_id	=	$mysql->insert($sql);
				
				
				$pl_id = 1;
										
				$p->add_field('business',$merchantEmail);
				$p->add_field('return', $this_script.'?action=success&pl_id='.$pl_id);
				$p->add_field('cancel_return', $this_script.'?action=cancel');
				$p->add_field('notify_url', $this_script.'?action=ipn&pl_id='.$pl_id);
				
				$p->add_field('tx', 'TransactionID');
				
				$p->add_field('amount', trim($pay_amount));
				
				$p->add_field('item_name', 'Gift card');
				
				$p->add_field('email',trim($customer_email));
				
				$p->add_field('currency_code', $currency_code);
				
				//$p->add_field('cmd', '_notify-validate');// append ipn command
				
				$p->submit_paypal_post();	//submit the fields to paypal
		  
			break;
		  
			case 'success':	// Order was successful...
	   
				// This is where you would probably want to thank the user for their order
				// or what have you.  The order information at this point is in POST 
				// variables.  However, you don't want to "process" the order until you
				// get validation from the IPN.  That's where you would have the code to
				// email an admin, update the database with payment status, activate a
				// membership, etc. 
				echo "success";
				
			break;
			
			case 'cancel':	// Order was canceled...			
				echo "cancel";	  
			break;
	
			case 'assign':	// Order was canceled...			
				echo "assign";
				exit;			  
			break;
		  
			case 'ipn':	// Paypal is calling page for IPN validation...
	   
				// It's important to remember that paypal calling this script.  There
				// is no output here.  This is where you validate the IPN data and if it's
				// valid, update your database to signify that the user has payed.  If
				// you try and use an echo or printf function here it's not going to do you
				// a bit of good.  This is on the "backend".  That is why, by default, the
				// class logs all IPN data to a text file.
				$subject = 'Instant Payment Notification - Step 1';
						$to = 'vineethclm@gmail.com';    //  your email
						$body =  "An instant payment notification was successfully recieved\n";
						//$body .= "from  on ".date('m/d/Y', time());
						//$body .= " at ".date('g:i A', time())."\n\nDetails:\n";
						$body .= serialize($p->ipn_data);
						@mail($to, $subject, $body);
				if ($p->validate_ipn()) 
				{
					
					if(isset($p->ipn_data['payment_status']) && trim($p->ipn_data['payment_status'])=='Completed') 
					{
						
						// Payment has been recieved and IPN is verified.  This is where you
						// update your database to activate or process the order, or setup
						// the database with the user's order details, email an administrator,
						// etc.  You can access a slew of information via the ipn_data() array.
				  
						// Check the paypal documentation for specifics on what information
						// is available in the IPN POST variables.  Basically, all the POST vars
						// which paypal sends, which we send back for validation, are now stored
						// in the ipn_data() array.
						 
						/* 
							$subject = 'Instant Payment Notification - Vineeth New';
							$to = 'vineethclm@gmail.com';    //  your email
							$body =  "An instant payment notification was successfully recieved\n";
							$body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
							$body .= " at ".date('g:i A')."\n\nDetails:\n";
						 
							foreach ($ses_array as $key => $value) { $body .= "\n$key: $value"; }
							mail($to, $subject, $body);
						*/
				  
						// For this example, we'll just email ourselves ALL the data.
						
						
						/*if($_POST['ticket_amount'] != '')
						{
							$total_amount	=	$_POST['ticket_quantity'] * $_POST['ticket_amount'];
							// Perform queries
							$ticket	=	mysqli_query($con,"INSERT INTO event_tickets (user_id,event_id,ticket_quantity,ticket_amount,total_amount,active) 
										VALUES ('" . $_POST['usr_id'] . "','" . $_POST['eve_id'] . "','" . $_POST['ticket_quantity'] . "','" . $_POST['ticket_amount'] . "','" . $total_amount . "',1)");
						}
						else
						{
							$ticket	=	mysqli_query($con,"INSERT INTO event_tickets (id,user_id,event_id,ticket_quantity,ticket_amount,total_amount,active) 
										VALUES ('','" . $_POST['usr_id'] . "','" . $_POST['eve_id'] . "','" . $_POST['ticket_quantity'] . "','0','0',1)");
						}*/
						
						
						//flash()->success(t('Tickets Purchased Successfully!'));
						
						$subject = 'Instant Payment Notification - Vineeth New';
						$to = 'vineethclm@gmail.com';    //  your email
						$body =  "An instant payment notification was successfully recieved\n";
						$body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y', time());
						//$body .= " at ".date('g:i A', time())."\n\nDetails:\n";
						$body .= "pl_id=".(int)$_GET['pl_id'].':::::::ipn_data='.serialize($p->ipn_data);
						@mail($to, $subject, $body);
					}
				}
				
			break;
		} 
		mysqli_close($con);
	}	
	#________________________________________________________ EOF PAYMENT ________________________________________________________#
?>
