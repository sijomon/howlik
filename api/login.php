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
		<form method="post" align="center" action="http://www.howlik.com/api/login" id="form">
			<h3>Login</h3> <br>
			</div>
			<input type="text" name="email" id="email" value="sanjups@gmail.com" placeholder="EMAIL" autocomplete="on" required />
			<div>
				<br>
			</div>
			<input type="password" name="password" id="password" value="123456" placeholder="PASSWORD" required />
			<div>
				<br>
			</div>
			<label>
				<input type="checkbox" name="remember" value="1" />
				Keep me logged in
			</label>
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="exfXrdUezLloc7LsaR0N6xJPEomnC6i2DEhx4B6h" />
			<button type="button" onclick="get()">Submit</button> <br>
			<a href="http://www.howlik.com/api/register.php" value="Register"/><button type="button">Register</button></a>
		</form>
		<br> <p align="center" id="output"></p> <br>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/login',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'email' : $('#email').val(), 'password' : $('#password').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data));
				}
			}
		});
	}
</script>