<?php 
$data=array(
'merchant_email'=>'yaagle_1225955852_biz@yahoo.com',
'product_name'=>'Product New test',
'amount'=>4.50,
'currency_code'=>'USD',
'thanks_page'=>"http://".$_SERVER['HTTP_HOST'].'/paypal/thank.php',
'notify_url'=>"http://".$_SERVER['HTTP_HOST'].'/paypal/ipn.php',
'cancel_url'=>"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
'paypal_mode'=>true
);	
if(isset($_POST['pay_now'])){
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
}else{
?>
<html>
<title>Integrate PayPal Payment gateway in php - InfoTuts</title>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<div id="mhead"><h2>Integrate PayPal Payment gateway in PHP - <span class="red">Info</span>Tuts</h2></div>

<div id="product">
<form id='paypal-info' method='post' action='#'>
<label>Product Name : <?php echo $data['product_name']; ?></label></br>
<label>Product Price : <?php echo $data['amount'].''.$data['currency_code']; ?></label>

<input type='submit' name='pay_now' id='pay_now' value='Pay' />
</form>
</div>



</html>
<?php
}
	function infotutsPaypal( $data) {

			define( 'SSL_URL', 'https://www.paypal.com/cgi-bin/webscr' );
			define( 'SSL_SAND_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr' );

			$action = '';
			//Is this a test transaction? 
			$action = ($data['paypal_mode']) ? SSL_SAND_URL : SSL_URL;

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
