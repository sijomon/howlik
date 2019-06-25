<?php 

	require_once('dbconnect.php');
	
	// currency convertion to USD
	if( isset($_POST['currency_code']) && $_POST['currency_code'] != '' )
	{
		$curr_code	= $_POST['currency_code'];
		$result		= mysqli_query($con,"SELECT cv_cur_val FROM bmd_currency_values WHERE cv_cur_code='INR'");
		if (mysqli_num_rows($result) > 0) 
		{
			// output value of the currency
			while($row = mysqli_fetch_assoc($result))
			{
				$curVal	=	$row['cv_cur_val'];
			}
		}
	}
	
	$pay_id	=	0;
	if( isset($_POST['biz_id']) && count($_POST) > 0 )
	{
		
		$pl_details	= $_POST;
		$pl_details['biz'] = array();
		
		$qry1 = mysqli_query($con, "SELECT user_id, title FROM business WHERE id='".$pl_details['biz_id']."'");
		if($row1 = mysqli_fetch_assoc($qry1)){
			$bizA['title']		=	$row1['title'];
			$bizA['user_id']	=	$row1['user_id'];
			$qry2 = mysqli_query($con, "SELECT name, phone, email FROM users WHERE id='".$row1['user_id']."'");
			if($row2 = mysqli_fetch_assoc($qry2)){
				$bizA['name']	=	$row2['name'];
				$bizA['phone']	=	$row2['phone'];
				$bizA['email']	=	$row2['email'];
			}
			$pl_details['biz'] = $bizA;
		}
		
		$qry2 = mysqli_query($con, "SELECT name, phone, email FROM users WHERE id='".$pl_details['sender_id']."'");
		if($row2 = mysqli_fetch_assoc($qry2)){
			$pl_details['sender_name']	=	$row2['name'];
			$pl_details['sender_phone']	=	$row2['phone'];
			$pl_details['sender_email']	=	$row2['email'];
		}
			
		$serialize_ses	=	serialize($pl_details);
		
		mysqli_query($con,"INSERT INTO paypal_log (pl_details, pl_status, pl_response, pl_type) VALUES ('". mysqli_real_escape_string($con, $serialize_ses) ."','0','0','gift_cert')");
		$pay_id =	mysqli_insert_id($con);
		
		$language_code = 'en';
		if( isset($_POST['language_code']) && $_POST['language_code'] ) {
			$language_code	=	$_POST['language_code'];
		}
		
		$biz_id	=	$_POST['biz_id'];
		$lan_id	=	$language_code;
		$amount	=	$_POST['gift_quantity'] * $_POST['gift_amount'];
		$converted_amount	=	$amount / $curVal;
	}
	
	$merchant_email = 'yaagle_1225955852_biz@yahoo.com';
	$test_mode		= true;
	$payDetQ	= mysqli_query($con,"SELECT * FROM payment_settings WHERE id='1'");
	if($payDet 	= mysqli_fetch_assoc($payDetQ)){
		$details = unserialize($payDet['details']);
		$merchant_email = $details['merch_email'];
		if($payDet['mode']=='live')
		$test_mode		= false;
	} 
	mysqli_close($con);
	
	$data = array (
		'merchant_email'=>	$merchant_email,
		'product_name'	=>	'Business Purchase',
		'amount'		=>	$converted_amount,
		'currency_code'	=>	'USD',
		'thanks_page'	=>	"http://".$_SERVER['HTTP_HOST'].'/api/giftpay/success.php?id='.$biz_id.'&lang='.$lan_id,
		'notify_url'	=>	"http://".$_SERVER['HTTP_HOST'].'/api/giftpay/ipn.php?id='.$pay_id,
		'cancel_url'	=>	"http://".$_SERVER['HTTP_HOST'].'/api/giftpay/cancel.php?id='.$biz_id.'&lang='.$lan_id,
		'test_mode'		=>	$test_mode,
	);	
	if( isset($_POST['pay_now']) ) {
		
		echo '<link rel="stylesheet" type="text/css" href="style.css" />';
		echo '<div class="wait">PayPal is processing the payment, please wait...</div>';
		echo '<div class="loader">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>';
		echo infotutsPaypal($data);
	}
	function infotutsPaypal( $data) {

		define( 'SSL_URL', 'https://www.paypal.com/cgi-bin/webscr' );
		define( 'SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );

		$action = '';
		//Is this a test transaction? 
		$action = ($data['test_mode']) ? SSL_SAND_URL : SSL_URL;

		$form = '';

		$form .= '<form name="frm_payment_method" action="' . $action . '" method="post">';
		$form .= '<input type="hidden" name="business" value="' . $data['merchant_email'] . '" />';
		// Instant Payment Notification & Return Page Details /
		$form .= '<input type="hidden" name="notify_url" value="' . $data['notify_url'] . '" />';
		$form .= '<input type="hidden" name="cancel_return" value="' . $data['cancel_url'] . '" />';
		$form .= '<input type="hidden" name="return" value="' . $data['thanks_page'] . '" />';
		$form .= '<input type="hidden" name="rm" value="2" />';
		// Configures Basic Checkout Fields -->
		$form .= '<input type="hidden" name="lc" value="" />';
		$form .= '<input type="hidden" name="no_shipping" value="1" />';
		$form .= '<input type="hidden" name="no_note" value="1" />';
		// <input type="hidden" name="custom" value="localhost" />-->
		$form .= '<input type="hidden" name="currency_code" value="' . $data['currency_code'] . '" />';
		$form .= '<input type="hidden" name="page_style" value="paypal" />';
		$form .= '<input type="hidden" name="charset" value="utf-8" />';
		$form .= '<input type="hidden" name="item_name" value="' . $data['product_name'] . '" />';
		$form .= '<input type="hidden" value="_xclick" name="cmd"/>';
		$form .= '<input type="hidden" name="amount" value="' . $data['amount'] . '" />';
		
		$form .= '</form>';
		$form .= '<script>';
		$form .= 'setTimeout("document.frm_payment_method.submit()", 0);';
		$form .= '</script>';
		return $form;
	}
