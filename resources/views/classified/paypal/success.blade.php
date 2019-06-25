<html>
	<head>
		<title>PayPal IPN Message in PHP</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div id="main">
			<div class="success_main_heading">
				<center><h1>PayPal IPN Example Using PHP</h1></center>
			</div>
			<div id="return">
				<h2>IPN Message Detail</h2>
				<hr/>
				<table id="results">
					<thead>
						<tr class="head">
							<th> Property </th>
							<th> Value </th>
						</tr>
					</thead>
					<tbody>
						<?php if (isset($_REQUEST['mc_gross'])) { ?>
						<tr>
							<td>
								mc_gross
							</td>
							<td>
								<?php echo $_REQUEST['mc_gross']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['protection_eligibility'])) { ?>
						<tr>
							<td>
								protection_eligibility
							</td>
							<td>
								<?php echo $_REQUEST['protection_eligibility']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payer_id'])) { ?>
						<tr>
							<td>
								payer_id
							</td>
							<td>
								<?php echo $_REQUEST['payer_id']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['tax'])) { ?>
						<tr>
							<td>
								tax
							</td>
							<td>
								<?php echo $_REQUEST['tax']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payment_date'])) { ?>
						<tr>
							<td>
								payment_date
							</td>
							<td>
								<?php echo $_REQUEST['payment_date']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payment_status'])) { ?>
						<tr>
							<td>
								payment_status
							</td>
							<td>
								<?php echo $_REQUEST['payment_status']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['charset'])) { ?>
						<tr>
							<td>
								charset
							</td>
							<td>
								<?php echo $_REQUEST['charset']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['first_name'])) { ?>
						<tr>
							<td>
								first_name
							</td>
							<td>
								<?php echo $_REQUEST['first_name']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['mc_fee'])) { ?>
						<tr>
							<td>
								mc_fee
							</td>
							<td>
								<?php echo $_REQUEST['mc_fee']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['notify_version'])) { ?>
						<tr>
							<td>
								notify_version
							</td>
							<td>
								<?php echo $_REQUEST['notify_version']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['custom'])) { ?>
						<tr>
							<td>
								custom
							</td>
							<td>
								<?php echo $_REQUEST['custom']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payer_status'])) { ?>
						<tr>
							<td>
								payer_status
							</td>
							<td>
								<?php echo $_REQUEST['payer_status']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['business'])) { ?>
						<tr>
							<td>
								business
							</td>
							<td>
								<?php echo $_REQUEST['business']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['quantity'])) { ?>
						<tr>
							<td>
								quantity
							</td>
							<td>
								<?php echo $_REQUEST['quantity']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payer_email'])) { ?>
						<tr>
							<td>
								payer_email
							</td>
							<td>
								<?php echo $_REQUEST['payer_email']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['txn_id'])) { ?>
						<tr>
							<td>
								txn_id
							</td>
							<td>
								<?php echo $_REQUEST['txn_id']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payment_type'])) { ?>
						<tr>
							<td>
								payment_type
							</td>
							<td>
								<?php echo $_REQUEST['payment_type']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['last_name'])) { ?>
						<tr>
							<td>
								last_name
							</td>
							<td>
								<?php echo $_REQUEST['last_name']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['receiver_email'])) { ?>
						<tr>
							<td>
								receiver_email
							</td>
							<td>
								<?php echo $_REQUEST['receiver_email']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payment_fee'])) { ?>
						<tr>
							<td>
								payment_fee
							</td>
							<td>
								<?php echo $_REQUEST['payment_fee']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['receiver_id'])) { ?>
						<tr>
							<td>
								receiver_id
							</td>
							<td>
								<?php echo $_REQUEST['receiver_id']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['txn_type'])) { ?>
						<tr>
							<td>
								txn_type
							</td>
							<td>
								<?php echo $_REQUEST['txn_type']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['item_name'])) { ?><tr>
							<td>
								item_name
							</td>
							<td>
								<?php echo $_REQUEST['item_name']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['mc_currency'])) { ?>
						<tr>
							<td>
								mc_currency
							</td>
							<td>
								<?php echo $_REQUEST['mc_currency']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['item_number'])) { ?>
						<tr>
							<td>
								item_number
							</td>
							<td>
								<?php echo $_REQUEST['item_number']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['residence_country'])) { ?><tr>
							<td>
								residence_country
							</td>
							<td>
								<?php echo $_REQUEST['residence_country']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['test_ipn'])) { ?><tr>
							<td>
								test_ipn
							</td>
							<td>
								<?php echo $_REQUEST['test_ipn']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['handling_amount'])) { ?><tr>
							<td>
								handling_amount
							</td>
							<td>
								<?php echo $_REQUEST['handling_amount']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['transaction_subject'])) { ?><tr>
							<td>
								transaction_subject
							</td>
							<td>
								<?php echo $_REQUEST['transaction_subject']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['payment_gross'])) { ?>
						<tr>
							<td>
								payment_gross
							</td>
							<td>
								<?php echo $_REQUEST['payment_gross']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['shipping'])) { ?>
						<tr>
							<td>
								shipping
							</td>
							<td>
								<?php echo $_REQUEST['shipping']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['merchant_return_link'])) { ?>
						<tr>
							<td>
								merchant_return_link
							</td>
							<td>
								<?php echo $_REQUEST['merchant_return_link']; ?>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['verify_sign'])) { ?>
						<tr>
							<td>
								verify_sign
							</td>
							<td>
								<div style="width: 255px; overflow: auto;">
									<?php echo $_REQUEST['verify_sign']; ?>
								</div>
							</td>
						</tr>
						<?php } if (isset($_REQUEST['auth'])) { ?>
						<tr>
							<td>
								auth
							</td>
							<td>
								<div style="width: 255px; overflow: auto;">
									<?php echo $_REQUEST['auth']; ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class='back_btn'><a href='index.php' id= 'btn'><< Back to Product </a></div>;
			</div>
			<!-- Right side div -->
			<div class="fr"id="formget">
				<a href=https://www.formget.com/app><img style="margin-left: 12%;" src="images/formget.jpg" alt="Online Form Builder"/></a>
			</div>
		</div>
	</body>
</html>

