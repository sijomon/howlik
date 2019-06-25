<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=number], input[type=password], select, textarea, button {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="" id="form">
			<h3>Get Business Booking</h3> <br>
			</div>
			<input type="text" name="apikey" value="983771521290634" id="apikey" placeholder="API KEY" required />
			<div>
				<br>
			</div>
			<input type="text" name="business_id" value="40" id="business_id" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<input type="text" name="country_code" id="country_code" placeholder="COUNTRY CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="city_code" id="city_code" placeholder="CITY CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="type" value="3" id="type" placeholder="BOOKING TYPE : 3 or 5" />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" />
			<div> <button type="button" onclick="get()">Submit</button> </div>
			<div> <a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a> </div>
		</form>
		<br> <p align="center" id="output"></p> <br>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/reservation/timeslot/load',
			type: 'GET',
			dataType: 'json',
			data: { 
			
				'apikey' : $('#apikey').val(), 
				'biz_id' : $('#business_id').val(), 
				'country_code' : $('#country_code').val(), 
				'city_code' : $('#city_code').val(), 
				'type' 	: $('#type').val(), 
			},
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
				}
			}
		});
	}
</script>