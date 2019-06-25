<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="exfXrdUezLloc7LsaR0N6xJPEomnC6i2DEhx4B6h">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=submit], input[type=number], input[type=password], input[type=email], select, textarea, button {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
			}
			label > input[type=text], input[type=number], select {
				width: 14.9% !important; 
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="http://www.howlik.com/api/update/business/get" id="form">
			<h3>Gift Certificate Create GET</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="913361515646355" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="language_code" id="language_code" value="en" placeholder="LANGUAGE CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="37" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="exfXrdUezLloc7LsaR0N6xJPEomnC6i2DEhx4B6h" />
			<button type="button" onclick="get()">Submit</button>
		</form>
		
		<br> <p align="center" id="output"></p> <br>
		
		<!-- <form method="post" align="center" action="http://www.howlik.com/api/giftpay/index.php" id="form"> -->
		<form method="post" align="center" action="http://www.howlik.com/api/create/certificate/post" id="form">
			<h3>Gift Certificate Create POST</h3> <br>
			<input type="text" name="apikey" id="api_key" placeholder="API KEY" required readonly />
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_id" value="37" placeholder="BUSINESS ID" readonly />
				<input type="text" name="biz_loc_id" value="26" placeholder="BUSINESS LOCATION ID" readonly />
			</label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="language_code" value="en" placeholder="LANGUAGE CODE" readonly />
				<input type="text" name="currency_code" id="currency_code" placeholder="CURRENCY CODE" readonly />
			</label>
			<div>
				<br>
			</div>
			<label>
				<select name="gift_quantity" id="gift_quantity" required>
					<option value="">QUANTITY</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
				<select name="gift_amount" id="gift_amount" required>
					<option value="">PRICE</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="300">300</option>
					<option value="500">500</option>
					<option value="1000">1000</option>
				</select>
			</label>
			<div>
				<br>
			</div>
			<input type="text" name="recipient_name[]" id="recipient_name" placeholder="RECIPIENT FULL NAME" required />
			<div>
				<br>
			</div>
			<input type="text" name="recipient_email[]" id="recipient_email" placeholder="RECIPIENT EMAIL" required />
			<div>
				<br>
			</div>
			<textarea name="recipient_message[]" id="recipient_message" placeholder="MESSAGE" rows="5"> Here is a gift for you! </textarea>
			<div>
				<br>
			</div>
			<input type="text" name="sender_name[]" id="sender_name" placeholder="SENDER NAME" />
			<div>
				<br>
			</div>
			<input type="hidden" name="_token" value="exfXrdUezLloc7LsaR0N6xJPEomnC6i2DEhx4B6h" />
			<input type='submit' name='pay_now' id='pay_now' value="Purchase" />
		</form>
	</body>
</html>
<script>

	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/create/certificate/load',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'language_code' : $('#language_code').val(), 'biz_id' : $('#biz_id').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
					$('input#api_key').val(data.apikey);
					$('input#sender_name').val(data.business.sender_name);
					$('input#currency_code').val(data.currency.currency_code);
				}
			}
		});
	}
	
</script>