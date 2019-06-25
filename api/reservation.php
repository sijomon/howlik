<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> | Howlik API Test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="csrf-token" content="6wWcGhF5VPiaoxH63e0HXqihzgqIzORzWZLDUhTA">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<style>
			input[type=text], input[type=submit], input[type=number], input[type=password], input[type=email], select, textarea, button {
				width: 30%;
				padding: 8px 16px;
				margin: 8px 0;
				box-sizing: border-box;
			}
			label > input[type=text] {
				width: 14.9%; 
			}
			label > select {
				width: 14.9%; 
			}
		</style>
	</head>
	<body>
		<form method="post" align="center" action="http://www.howlik.com/api/create/offer/get" id="form">
			<h3>Reservation GET</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="536761515737441" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="37" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="6wWcGhF5VPiaoxH63e0HXqihzgqIzORzWZLDUhTA" />
			<button type="button" onclick="get()">Submit</button>
		</form>
		
		<br> <p align="center" id="output"></p> <br>
		
		<!-- <form method="post" align="center" action="http://www.howlik.com/api/giftpay/index.php" id="form"> -->
		<form method="post" align="center" action="http://www.howlik.com/api/update/offer/post" id="form">
			<h3>Reservation POST</h3> <br>
			<input type="text" name="apikey" id="_api_key" placeholder="API KEY" required readonly />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="_biz_id" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<div id="tble">
				<h5> Table Booking </h5>
				<div>
					<br>
				</div>
				<label>
					<input type="text" name="date_of" id="date_of" value="" placeholder="DATE" />
					<select name="time_of" id="time_of" required>
					<option value="">TIME</option>
				</select>
				</label>
				<div>
					<br>
				</div>
				<select name="number_of" id="number_of" required>
					<option value="">NO.OF PEOPLE</option>
					<option value="1">1 People</option>
					<option value="2">2 People</option>
					<option value="3">3 People</option>
					<option value="4">4 People</option>
					<option value="5">5 People</option>
					<option value="6">6 People</option>
				</select>
				<div>
					<br>
				</div>
			</div>
			<div id="time">
				<h5> Time Slot Booking </h5>
				<div>
					<br>
				</div>
				<label>
					<input type="text" name="date_of" id="date_of" value="" placeholder="DATE" />
					<select name="time_of" id="time_of" required>
					<option value="">TIME</option>
				</select>
				</label>
				<div>
					<br>
				</div>
				<select name="number_of" id="number_of" required>
					<option value="">NO.OF PEOPLE</option>
					<option value="1">1 People</option>
					<option value="2">2 People</option>
					<option value="3">3 People</option>
					<option value="4">4 People</option>
					<option value="5">5 People</option>
					<option value="6">6 People</option>
				</select>
				<div>
					<br>
				</div>
			</div>
			<input type="hidden" name="_token" value="6wWcGhF5VPiaoxH63e0HXqihzgqIzORzWZLDUhTA" />
			<button type="submit">Submit</button>
		</form>
	</body>
</html>
<script>

	$('div#tble').hide();
	$('div#time').hide();
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/reservation/load',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'biz_id' : $('#biz_id').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
					$('input#_api_key').val($('#apikey').val());
					$('input#_biz_id').val($('#biz_id').val());
				}
				if( data.type == 3 ) {
					$('div#tble').show();
				}
				else if( data.type == 5 ) {
					$('div#time').show();
				}
			}
		});
	}
	
</script>