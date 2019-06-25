<?php
session_start();
require_once('globals.php');
require_once('oauth_helper.php'); 
// Fill in the next 3 variables. 
$request_token           =   $_SESSION['request_token'];
$request_token_secret   =   $_SESSION['request_token_secret'];
$oauth_verifier        =   $_GET['oauth_verifier']; 
  // Get the access token using HTTP GET and HMAC-SHA1 signature 
  $retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true); 
  if (! empty($retarr)) { 
  list($info, $headers, $body, $body_parsed) = $retarr;
  if ($info['http_code'] == 200 && !empty($body)) { 
  //   print "Use oauth_token as the token for all of your API calls:\n" . 
  //      rfc3986_decode($body_parsed['oauth_token']) . "\n"; 
  // Fill in the next 3 variables. 
  $guid    =  $body_parsed['xoauth_yahoo_guid'];
   $access_token  = rfc3986_decode($body_parsed['oauth_token']) ;
    $access_token_secret  = $body_parsed['oauth_token_secret']; 
	// Call Contact API 
	$retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);
	//echo "<pre/>";
	//print_r($retarrs);
	    
	    
	    $str1 = explode(",",$retarrs);
		foreach($str1 as $s)
		{
			$abc = explode(":",$s);
			//echo "<pre>";print_r($abc[0]);
			//echo "<pre>";print_r($abc[1]);
		}
        $_SESSION['yahoo_contacts'] = $str1;
		
		//echo "<pre>";print_r($_SESSION['yahoo_contacts']);
		//header('location:http://www.howlik.com/en/find_friends')
		
}}
echo '<script language="javascript">window.location.href="http://www.howlik.com/en/find_friends";</script>';
?> 