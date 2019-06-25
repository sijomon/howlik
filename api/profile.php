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
		<form method="post" align="center" action="http://www.howlik.com/api/profile/get" id="form">
			<h3>Get Profile</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="883011517475284" required />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" />
			<div><button type="button" onclick="get()">Submit</button></div>
			<div><a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a></div>
		</form>
		
		<br> <p id="output" align="center"></p> <br>
		
		<form method="post" align="center" action="http://www.howlik.com/api/profile" id="form">
			<h3>Edit Profile</h3> <br>
			<input type="text" name="apikey" id="api_key" placeholder="API KEY" required readonly />
			<div>
				<br><br>
			</div>
			<select name="gender" id="gender" required>
				<option value="">GENDER</option>
				<option value="1">Male</option>
				<option value="2">Female</option>
			</select>
			<div>
				<br>
			</div>
			<input type="text" name="name" id="name" placeholder="NAME" required /> 
			<div>
				<br>
			</div>
			<select name="country" id="country" required>
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
			<input type="text" name="phone" id="phone" placeholder="PHONE" required />
			<div>
				<br>
			</div>
			<input type="text" name="email" id="email" placeholder="EMAIL" required />
			<div>
				<br>
			</div>
			<input type="hidden" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" />
			<button type="submit">Submit</button>
		</form>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/profile/load',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
					$('#name').val(data.profile.name);
					$('#phone').val(data.profile.phone);
					$('#email').val(data.profile.email);
					$('#country').val(data.profile.country_code);
					$('#gender').val(data.profile.gender_id);
					$('#api_key').val(data.profile.api_key);
				}
			}
		});
	}
</script>