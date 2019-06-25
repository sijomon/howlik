<?php

	// set API Endpoint, Access Key, required parameters
	$endpoint = 'live';
	$access_key = 'c9e398ba5326474e6f0c16a0111bf5bb';

	$cur = 'CAD,USD,AUD,PLN,MXN,INR';

	// initialize CURL:
	$ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'&&currencies='.$cur.'&format=1');   
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// get the (still encoded) JSON data:
	$json = curl_exec($ch);
	//echo $json;
	curl_close($ch);

	// Decode JSON response:
	$conversionResult = json_decode($json, true);

	// access the conversion result
	echo "<pre>"; print_r($conversionResult);

?>