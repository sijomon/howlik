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
			<h3>Friends</h3> <br>
			</div>
			<div><input type="text" name="apikey" id="apikey" placeholder="API KEY" value="707351522319778" required /></div>
			<div><input type="text" name="user_id" id="user_id" placeholder="USER ID" value="37" required /></div>
			<div><button type="button" onclick="get()">Submit</button></div>
			<div><a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a></div>
		</form>
		<br> <p align="center" id="output"></p> <br>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/friends',
			type: 'POST',
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'user_id' : $('#user_id').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data));
				}
			}
		});
	}
</script>