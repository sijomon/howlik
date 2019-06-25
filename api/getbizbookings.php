<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="6wWcGhF5VPiaoxH63e0HXqihzgqIzORzWZLDUhTA">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=submit], input[type=number], input[type=password], input[type=email], select, textarea, button {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
			}
			label > input[type=text] {
				width: 14.9%; 
			}
			label > select {
				width: 14.9%; 
			}
		</style>
	</head>
	<body>
	
		<form method="post" align="center" action="http://www.howlik.com/api/create/offer/get" id="form">
			<h3>Get My Bookings</h3> <br>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="707351522319778" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="language_code" id="language_code" value="en" placeholder="LANGUAGE CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<button type="button" onclick="get()">Submit</button>
		</form>
		
		<br> <p align="center" id="output"></p> <br>
		
	</body>
</html>
<script>

	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/business/booking',
			type: 'GET',
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'language_code' : $('#language_code').val(), 'biz_id' : $('#biz_id').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
				}
			}
		});
	}
	
</script>
</script>
</script>