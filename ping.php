<?php
/*************************************************************************************************************************/
/*                                                  PING GOOGLE                                                          */
/*************************************************************************************************************************/
//We will dynamically create Search Engine URL
$ping_url = '';
$sitemap_url = 'http://www.howlik.com/sitemap.xml';
//Create Ping URL with your Sitemap URL
$ping_url = "http://www.google.com/webmasters/tools/ping?sitemap=" . urlencode($sitemap_url);
//capture response of Google.
//wp_remote_get is WordPress specific function.Users of other content management system can use similar function
$search_response = file_get_contents( $ping_url );
echo $search_response;
//check the ping status
/*if($Search_response['response']['code']==200)
{
  echo "Pinged Google Successfully";
}
else 
{
  echo "Failed to ping Google.";
}*/
exit;
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