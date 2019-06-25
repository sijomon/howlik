<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" rel="stylesheet" />
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
	
		<form method="post" align="center" action="http://www.howlik.com/api/update/business/hours" enctype="multipart/form-data" id="form">
			<h3>Business Hours Update </h3> <br>
			<input type="text" name="apikey" id="api_key" placeholder="API KEY" value="261671520243005" required readonly />
			<div>
				<br><br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="6007" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="0" readonly />
				<input type="text" name="biz_start_hours[]" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="1" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="2" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="3" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="4" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="5" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<label>
				<input type="text" name="biz_days[]" id="biz_days" value="6" readonly />
				<input type="text" name="biz_start_hours[]" id="biz_start_hours" class="timepicker" placeholder="START TIME" />
				<input type="text" name="biz_end_hours[]" id="biz_end_hours" class="timepicker" placeholder="END TIME" />
			<label>
			<div>
				<br>
			</div>
			<div><input type="hidden" name="_token" value="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu" /></div><div>
				<br>
			</div>
			<div><button type="submit">Submit</button></div><div>
				<br>
			</div>
		</form>
		
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
</html>