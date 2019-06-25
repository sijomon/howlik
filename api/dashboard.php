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
			label > input[type=text], input[type=number] {
				width: 14.9% !important; 
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="http://www.howlik.com/api/dashboard" id="form">
			<h3>Dashboard</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="332761518150651" required />
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="latitude" id="latitude" placeholder="LATITUDE" value="9.998480" required />
				<input type="text" name="longitude" id="longitude" placeholder="LONGITUDE" value="76.311936" required />
			</label>
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" />
			<button type="button" onclick="get()">Submit</button> <br>
			<a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a>
		</form>
		<br> <p align="center" id="output"></p> <br>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/dashboard',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'latitude' : $('#latitude').val(), 'longitude' : $('#longitude').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
				}
			}
		});
	}
</script>