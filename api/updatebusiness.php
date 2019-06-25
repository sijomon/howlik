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
			<h3>Business Create GET</h3> <br>
			</div>
			<input type="text" name="apikey" id="apikey" placeholder="API KEY" value="722141518085213" autocomplete="on" />
			<div>
				<br>
			</div>
			<input type="text" name="language_code" id="language_code" value="en" placeholder="LANGUAGE CODE" />
			<div>
				<br>
			</div>
			<input type="text" name="biz_id" id="biz_id" value="6007" placeholder="BUSINESS ID" />
			<div>
				<br>
			</div>
			<input type="hidden" id="token" name="_token" value="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu" />
			<button type="button" onclick="get()">Submit</button>
		</form>
		
		<br> <p align="center" id="output"></p> <br>
		
		<form method="post" align="center" action="http://www.howlik.com/api/update/business/post" enctype="multipart/form-data" id="form">
			<h3>Business Create POST</h3> <br>
			<input type="text" name="apikey" id="api_key" placeholder="API KEY" required readonly />
			<div>
				<br><br>
			</div>
			<select name="category_id" id="category_id" onchange="keywords(this.value);" required>
				<option value="">CATEGORY</option>
				<option value="669"> Arts &amp; Entertainment </option>
				<option value="712"> Beauty &amp; Spas </option>
				<option value="730"> Education </option>
				<option value="775"> Food &amp; Drinks </option>
				<option value="803"> Health </option>
				<option value="873"> Travel &amp; Tourism </option>
				<option value="949"> Professional Services </option>
				<option value="974"> Goverment Services </option>
				<option value="992"> Religion </option>
				<option value="997"> Hotels </option>
				<option value="1105"> Shopping </option>
				<option value="59"> Family </option>
				<option value="141"> Sports &amp; Activities </option>
				<option value="75"> Freelancers </option>
			</select>
			<div>
				<br>
			</div>
			<input type="text" name="business_title" id="business_title" placeholder="BUSINESS TITLE" required />
			<div>
				<br>
			</div>
			<textarea name="business_desc" id="business_desc" placeholder="BUSINESS DESCRIPTION" rows="5"></textarea>
			<div>
				<br>
			</div>
			<input type="text" name="website_url" id="website_url" placeholder="WEBSITE URL" />
			<div>
				<br>
			</div>
			<input type="text" name="phone_number" id="phone_number" placeholder="PHONE NUMBER" required />
			<div>
				<br>
			</div>
			<textarea name="address_one" id="address_one" placeholder="ADDRESS ONE" rows="5"></textarea>
			<div>
				<br>
			</div>
			<textarea name="address_two" id="address_two" placeholder="ADDRESS TWO" rows="5"></textarea>
			<div>
				<br>
			</div>
			<select id="location_code" name="location_code" onchange="generate(this.value);" required>
				<option value="">LOCATION</option>
				<option value="IN.01">Andhra Pradesh</option>
				<option value="IN.02">Arunachal Pradesh</option>
				<option value="IN.03">Assam</option>
				<option value="IN.04">Bihar</option>
				<option value="IN.05">Chandigarh</option>
				<option value="IN.06">Chhattisgarh</option>
				<option value="IN.07">Dadra and Nagar Haveli</option>
				<option value="IN.08">Daman and Diu</option>
				<option value="IN.24">Delhi</option>
				<option value="IN.09">Goa</option>
				<option value="IN.10">Gujarat</option>
				<option value="IN.11">Haryana</option>
				<option value="IN.12">Himachal Pradesh</option>
				<option value="IN.13">Jharkhand</option>
				<option value="IN.14">Karnataka</option>
				<option value="IN.15">Kashmir</option>
				<option value="IN.16">Kerala</option>
				<option value="IN.17">Lakshadweep</option>
				<option value="IN.18">Madhya Pradesh</option>
				<option value="IN.19">Maharashtra</option>
				<option value="IN.20">Manipur</option>
				<option value="IN.21">Meghalaya</option>
				<option value="IN.22">Mizoram</option>
				<option value="IN.23">Nagaland</option>
				<option value="IN.25">Odisha</option>
				<option value="IN.32">Puducherry</option>
				<option value="IN.26">Punjab</option>
				<option value="IN.27">Rajasthan</option>
				<option value="IN.28">Sikkim</option>
				<option value="IN.29">Tamil Nadu</option>
				<option value="IN.30">Telangana</option>
				<option value="IN.31">Tripura</option>
				<option value="IN.33">Uttar Pradesh</option>
				<option value="IN.34">Uttarakhand</option>
				<option value="IN.35">West Bengal</option>
			</select>
			<div>
				<br>
			</div>
			<select name="city_code" id="city_code" required>
				<option value="">CITY</option>
				<option value="1253392">Varkala</option>
				<option value="1253450">Vandiperiyar</option>
				<option value="1253500">Azhikkal</option>
				<option value="1253544">Vaikam</option>
				<option value="1254040">Turavur</option>
				<option value="1254163">Thiruvananthapuram</option>
				<option value="1254187">Thrissur</option>
				<option value="1254335">Tiruvalla</option>
				<option value="1254345">Tirurangadi</option>
				<option value="1254346">Tirur</option>
				<option value="1254780">Tellicherry</option>
				<option value="1254996">Tangasseri</option>
				<option value="1256432">Shoranur</option>
				<option value="1259091">Kollam</option>
				<option value="1259217">Punnapra</option>
				<option value="1259243">Punalur</option>
				<option value="1259411">Ponnani</option>
				<option value="1259994">Payyanur</option>
				<option value="1260052">Pattambi</option>
				<option value="1260138">Pathanamthitta</option>
				<option value="1260225">Parur</option>
				<option value="1260375">Parappanangadi</option>
				<option value="1260728">Palakkad</option>
				<option value="1261008">Ottappalam</option>
				<option value="1261394">Nileshwar</option>
				<option value="1262566">Muluppilagadu</option>
				<option value="1263285">Mavelikara</option>
				<option value="1263694">Manjeri</option>
				<option value="1263959">Mananthavady</option>
				<option value="1264154">Malappuram</option>
				<option value="1264403">Mahe</option>
				<option value="1265395">Kuttippuram</option>
				<option value="1265418">Kutiatodu</option>
				<option value="1265579">Kunnamkulam</option>
				<option value="1265873">Kozhikode</option>
				<option value="1265911">Kottayam</option>
				<option value="1265916">Kottarakara</option>
				<option value="1265932">Kottakkal</option>
				<option value="1266385">Kodungallur</option>
				<option value="1267355">Kazhakuttam</option>
				<option value="1267360">Kayamkulam</option>
				<option value="1267435">Kattanam</option>
				<option value="1267616">Kasaragod</option>
				<option value="1268015">Kanhangad</option>
				<option value="1268327">Kalpetta</option>
				<option value="1268512">Kaladi</option>
				<option value="1269692">Iritty</option>
				<option value="1269693">Irinjalakuda</option>
				<option value="1269811">Idukki</option>
				<option value="1271888">Ferokh</option>
				<option value="1272022">Erattupetta</option>
				<option value="1272110">Edapalli</option>
				<option value="1273874">Kochi</option>
				<option value="1274428">Chengannur</option>
				<option value="1274468">Chavakkad</option>
				<option value="1274664">Changanacheri</option>
				<option value="1274987">Kannur</option>
				<option value="1276623">Bedradka</option>
				<option value="1278176">Attingal</option>
				<option value="1278654">Anchal</option>
				<option value="1278858">Ambalapuzha</option>
				<option value="1278985">Alappuzha</option>
				<option value="1279069">Alanallur</option>
				<option value="6694343">Kaudiar</option>
				<option value="7279600">Aluva</option>
				<option value="7279735">Muvattupuzha</option>
				<option value="7279739">Perumbavoor</option>
				<option value="7667973">Amaravathy</option>
				<option value="7870662">Vyttila</option>
				<option value="8181689">Chendamangalam</option>
				<option value="8443020">Trikkandiyur</option>
				<option value="9072827">Thodupuzha</option>
				<option value="10376565">Ponkunnam</option>
				<option value="10627510">Kumbalam</option>
				<option value="10628607">Aroor</option>
				<option value="10792588">Cherthala</option>
				<option value="10846540">Anekallu</option>
				<option value="10877828">Cherur</option>
				<option value="10877860">Chittari</option>
				<option value="10877867">Alakode</option>
				<option value="10878022">Kakkat</option>
				<option value="10891306">Bandadka</option>
				<option value="10910174">Pallikunnu</option>
				<option value="10910176">Chirakkal</option>
				<option value="10910201">Kannadiparamba</option>
				<option value="10924976">Chelakkad</option>
				<option value="10925345">Chemancheri</option>
				<option value="10925351">Cheliya</option>
				<option value="10929650">Etakkad</option>
				<option value="10929655">Karaparamba</option>
				<option value="10929778">Avilora</option>
				<option value="10930024">Athalur</option>
				<option value="10930060">Ayilakkad</option>
				<option value="10930077">Tavanur</option>
				<option value="10930098">Chennara</option>
				<option value="10930105">Niramaruthur</option>
				<option value="10933957">Marancheri</option>
				<option value="11073561">Kakkanad</option>
				<option value="11184574">Peruvemba</option>
				<option value="11185179">Edavilangu</option>
				<option value="11185507">Kainoor</option>
				<option value="11185833">Maradu</option>
				<option value="11186354">Chayalode</option>
			</select>
			<div>
				<br>
			</div>
			<input type="text" name="zip_code" id="zip_code" placeholder="ZIP CODE" />
			<div>
				<br>
			</div>
			<input type="hidden" name="_token" value="AM1dii2E5L1DlPKjfPmYqw5T7FrSRgxiMT5oUsHu" />
			<button type="submit">Submit</button>
		</form>
	</body>
</html>
<script>

	$('input.ticket_type').change( function() {
		if( $(this).val() == 0 ) {
			$('input#ticket_count').attr('readonly', 'readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_count').val('');
			$('input#ticket_price').val('');
		}
		else if( $(this).val() == 1 ) {
			$('input#ticket_count').focus();
			$('input#ticket_count').removeAttr('readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_price').val('');
		}
		else if( $(this).val() == 2 ) {
			$('input#ticket_count').focus();
			$('input#ticket_count').removeAttr('readonly');
			$('input#ticket_price').removeAttr('readonly');
		}
		else {
			$('input#ticket_count').attr('readonly', 'readonly');
			$('input#ticket_price').attr('readonly', 'readonly');
			$('input#ticket_count').val('');
			$('input#ticket_price').val('');
		}
	});
	
	$('input.event_privacy').change( function() {
		if( $(this).val() == 0 ) {
			$('input#visible_to').attr('readonly', 'readonly');
			$('input#visible_to').removeAttr('required');
			$('input#visible_to').val('');
		}
		else if( $(this).val() == 1 ) {
			$('input#visible_to').focus();
			$('input#visible_to').removeAttr('readonly');
			$('input#visible_to').attr('required', 'required');
		}
		else {
			$('input#visible_to').attr('readonly', 'readonly');
			$('input#visible_to').removeAttr('required');
			$('input#visible_to').val('');
		}
	});
	
	function get() {
		
		$.ajax({
			url: 'http://www.howlik.com/api/update/business/load',
			type: 'GET',
			headers: {
				'X-CSRF-TOKEN': $('#token').val()
			},
			dataType:'json',
			data: { 'apikey' : $('#apikey').val(), 'language_code' : $('#language_code').val(), 'biz_id' : $('#biz_id').val() },
			success: function(data) {
				if(data) {
					console.log(data);
					$('#output').html(JSON.stringify(data.status));
					$('input#api_key').val(data.apikey);
					$('select#category_id').val(data.business.category_id);
					$('input#business_title').val(data.business.title);
					$('textarea#business_desc').val(data.business.description);
					$('input#website_url').val(data.business.website);
					$('input#phone_number').val(data.business.phone);
					$('textarea#address_one').val(data.business.address1);
					$('textarea#address_two').val(data.business.address2);
					$('select#location_code').val(data.business.subadmin1_code);
					$('select#city_code').val(data.business.city_id);
					$('input#zip_code').val(data.business.zip);
				}
			}
		});
	}
	
	function keywords(value) {
		
		if( value ) {
			$.ajax({
				url: 'http://www.howlik.com/api/generate/keyword',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('#token').val()
				},
				dataType:'json',
				data: { 'apikey' : $('#api_key').val(), 'category_id' : value },
				success: function(data) {
					if(data) {
						console.log(data);
						$('#output').html(JSON.stringify(data.status));
					}
				}
			});
		}
	}
	
	function generate(value) {
		
		if( value ) {
			$.ajax({
				url: 'http://www.howlik.com/api/generate/city',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('#token').val()
				},
				dataType:'json',
				data: { 'apikey' : $('#api_key').val(), 'location_code' : value },
				success: function(data) {
					if(data) {
						console.log(data);
						$('#output').html(JSON.stringify(data.status));
					}
				}
			});
		}
	}
	
</script>