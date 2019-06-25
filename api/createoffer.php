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
		<form method="post" align="center" action="http://www.howlik.com/api/create/offer/get" id="form">
			<h3>Offer Create GET</h3> <br>
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
		<form method="post" align="center" action="http://www.howlik.com/api/create/offer/post" id="form">
			<h3>Offer Create POST</h3> <br>
			<input type="text" name="apikey" id="_api_key" placeholder="API KEY" required readonly />
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_id" value="37" placeholder="BUSINESS ID" readonly />
				<select name="offer_type" id="offer_type" required>
					<option value="">OFFER TYPE</option>
					<option value="1">Percent Offer</option>
					<option value="2">Price Offer</option>
					<option value="3">Free Offer</option>
					<option value="4">Fixed Price</option>
				</select>
			</label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="offer_percent" placeholder="OFFER PERCENT" />
				<input type="text" name="offer_content" placeholder="OFFER CONTENT" />
			</label>
			<div>
				<br>
			</div>
			<textarea name="offer_desc" id="offer_desc" placeholder="OFFER DESCRIPTION" rows="5"></textarea>
			<div>
				<br>
			</div>
			<input type="hidden" name="_token" value="exfXrdUezLloc7LsaR0N6xJPEomnC6i2DEhx4B6h" />
			<button type="submit">Submit</button>
		</form>
	</body>
</html>
<script>

	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/create/offer/load',
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
					$('input#_api_key').val(data.apikey);
				}
			}
		});
	}
	
</script>