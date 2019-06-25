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
		<form method="post" align="center" action="http://www.howlik.com/api/busines/single" id="form">
			<h3>Get Business</h3> <br>
			</div>
			<input type="text" name="apikey" value="217811519360805" id="apikey" placeholder="API KEY" required />
			<div>
				<br>
			</div>
			<input type="text" name="language_code" id="language_code" placeholder="LANGUAGE CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="country_code" id="country_code" placeholder="COUNTRY CODE" />
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
			url: 'http://www.howlik.com/api/generate/country',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 
				'apikey' : $('#apikey').val(), 
				'language_code' : $('#language_code').val(), 
				'country_code'  : $('#country_code').val()
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