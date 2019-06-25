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
			input[type=file] {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
				border: 1px solid #a9a9a9;
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="http://www.howlik.com/api/upload/event/image" id="form" enctype="multipart/form-data">
			<h3>File Upload</h3> <br>

			<div><input type="hidden" id="token" name="_token" value="wtiCpNPJTDyBrwFJeko1BTRNglbhKgKgbFdLFdZJ" /><div>
			
			<div><input type="text" name="apikey" id="apikey" placeholder="API KEY" value="913181517978089" required /> </div> </br>
			
			<div><input type="text" name="event_id" id="event_id" placeholder="EVENT ID" value="" /></div> </br>
			
			<div><input type="file" name="file" id="file" placeholder="" required /></div> </br>
			
			<div><button type="submit">Submit</button></div>
			<!-- <div><button type="button" onclick="get()">Submit</button></div> -->
			
			<div><a href="http://www.howlik.com/api/login.php"><button type="button">Login</button></a></div>
		</form>
		<div align="center"> <p id="output"></p> <div>
	</body>
</html>
<script>
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/uplaod/event/image',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'event_id' : $('#event_id').val(), 'image' : $('#image').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
				}
			}
		});
	}
</script>