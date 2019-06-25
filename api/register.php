<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="L2XrlXSGYVKGI945kJGyinuDJ02XkHr2yIG1TjRL">
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
		<form method="post" align="center" action="http://www.howlik.com/api/register" id="form">
			<h3>Register</h3> <br>
			<select name="gender" required>
				<option value="">GENDER</option>
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
			<div>
				<br>
			</div>
			<input type="text" placeholder="NAME" name="name" required /> 
			<div>
				<br>
			</div>
			<label>
				<input type="radio" name="usertype" value="2" checked /> Company
				<input type="radio" name="usertype" value="3" /> Individual
			</label>
			<div>
				<br>
			</div>
			<select name="country" required>
				<option value="">COUNTRY</option>
				<option value="BH"> Bahrain </option>
				<option value="IN"> India </option>
				<option value="KW"> Kuwait </option>
				<option value="OM"> Oman </option>
				<option value="QA"> Qatar </option>
				<option value="SA"> Saudi Arabia </option>
				<option value="AE"> United Arab Emirates </option>	
			</select>
			<div>
				<br>
			</div>
			<input type="text" placeholder="PHONE" name="phone" autocomplete="off" required />
			<div>
				<br>
			</div>
			<input type="text" placeholder="EMAIL" name="email" autocomplete="on" required />
			<div>
				<br>
			</div>
			<input type="password" placeholder="PASSWORD" name="password" required />
			<div>
				<br><br>
			</div>
			<input type="hidden" id="token" name="_token" value="L2XrlXSGYVKGI945kJGyinuDJ02XkHr2yIG1TjRL" />
			<button type="submit">Submit</button><br>
			<a href="http://www.howlik.com/api/login.php" value="Login"/><button type="button">Login</button></a>
		</form>
	</body>
</html>

<script>

	function submit() {

		$.ajax({

			url: 'http://www.howlik.com/api/register',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { },
			success: function(data) {

				if(data) {
					
				}
			}
		});

	}

</script>