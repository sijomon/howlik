<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=number], input[type=password], input[type=email], select, textarea, button {
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
	
		<form method="post" align="center" action="http://www.howlik.com/api/update/business/get" id="form">
			<h3> Enable / Disable Business Booking </h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="602681520844100" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="37" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<label><input type="radio" name="status" id="status" value="0" checked /> Disable
			<input type="radio" name="status" id="status" value="1" /> Enable </label>
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu" />
			<button type="button" onclick="go()">Submit</button>
		</form>
		
		<br> <p align="center"></p> <br>
		
	</body>
</html>
<script>

	function go() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/biz/booking/edit',
			type: 'get',
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'biz_id' : $('#biz_id').val(), 'status' : $("input[name='status']:checked").val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('p').html(JSON.stringify(data.status));
				}
			}
		});
	}
	
</script>