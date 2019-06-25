<?php

	$ch = curl_init("http://www.howlik.com/paypal/currency/");
	$fp = fopen("index.php", "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
?>