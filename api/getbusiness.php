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
		<form method="POST" align="center" action="http://www.howlik.com/api/busines/single" id="form">
			<h3>Get Business</h3> <br>
			</div>
			<input type="text" name="apikey" value="141931529392577" id="apikey" placeholder="API KEY" required />
			<div>
				<br>
			</div>
			<input type="text" name="business_id" value="53" id="business_id" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<!--<input type="text" name="apikey" value="457111522844721" id="apikey" placeholder="API KEY" required />
			<div>
				<br>
			</div>
			<!-- <input type="text" name="category_id" id="category_id" placeholder="CATEGORY ID" /> -->
			<!--<input type="text" name="business_id" value="37" id="business_id" placeholder="BUSINESS ID" />
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
			<input type="text" name="latitude" value="9.998480" id="latitude" placeholder="LATITUDE" />
			<div>
				<br>
			</div><input type="text" name="longitude" value="76.311936" id="longitude" placeholder="LONGITUDE" />
			<div>
				<br>
			</div>---->
			<input type="hidden" id="token" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" />
			<div> <button type="button" onclick="get()">Submit</button> </div>
			<!---<div> <a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a> </div> --->
		</form>
		<br> <p align="center" id="output"></p> <br>
	</body>
</html>
<script>
function get() {
		
		$.ajax({
			url: 'https://www.howlik.com/api/delete/business',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 
			
				'apikey' : $('#apikey').val(), 
				'biz_id' : $('#business_id').val(),
			},
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data));
				}
			}
		});
	}
	/* function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/business/single',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 
			
				'apikey' : $('#apikey').val(), 
				'biz_id' : $('#business_id').val(), 
				'country_code' : $('#country_code').val(), 
				'city_code' : $('#city_code').val(), 
				'latitude' 	: $('#latitude').val(), 
				'longitude' : $('#longitude').val(), 
				'category_id' : 974,
			},
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data));
				}
			}
		});
	} */
</script>