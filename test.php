<?php

function curl_fetch($Url, $refUrl=''){
	if (!function_exists('curl_init')){die('Sorry cURL is not installed!');}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	if($refUrl!=''){
		curl_setopt($ch, CURLOPT_REFERER, $refUrl);
	}
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/4.0");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

// This is the URL you want to shorten
$longUrl = 'http://demo.hesabe.com//smspay/TPL12322112.910625955d85d6eedf';

// Get API key from : http://code.google.com/apis/console/
$apiKey = 'AIzaSyAJJPRazt9V6iyqO928urRZkZAO_gN8pBo';

$postData = array('longUrl' => $longUrl, 'key' => $apiKey);
$jsonData = json_encode($postData);

$Url = 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey;

$res = curl_post($Url, $jsonData);
echo "<pre>";
print_r($res);

function curl_post($Url, $jsonData){
	if (!function_exists('curl_init')){die('Sorry cURL is not installed!');}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($ch);

	// Change the response json string to object
	$json = json_decode($response);

	curl_close($ch);
	return $json;
}
?>