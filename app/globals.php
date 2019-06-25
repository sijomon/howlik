<?php
namespace App;

	class globals1
	{
	


			session_start();
			/**
			 * Globals and utilities for OAuth Examaples package
			 */

			// Fill in the next two constants
			define('OAUTH_CONSUMER_KEY', 'dj0yJmk9Q1c2SDVhYWFPdEw5JmQ9WVdrOVNFWlpORlZOTkdFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0xNg--');
			define('OAUTH_CONSUMER_SECRET', '43a4f8aad6622c7a4e2d13cd5fdb6579079516ac');

			//$progname = $argv[0];
			$debug = 0; // Set to 1 for verbose debugging output

			function logit($msg,$preamble=true)
			{
			  //  date_default_timezone_set('America/Los_Angeles');
			  $now = date(DateTime::ISO8601, time());
			  error_log(($preamble ? "+++${now}:" : '') . $msg);
			}

			/**
			 * Do an HTTP GET
			 * @param string $url
			 * @param int $port (optional)
			 * @param array $headers an array of HTTP headers (optional)
			 * @return array ($info, $header, $response) on success or empty array on error.
			 */
			function do_get($url, $port=80, $headers=NULL)
			{
			  $retarr = array();  // Return value
			  
			  $curl_opts = array(CURLOPT_URL => $url,
								 CURLOPT_PORT => $port,
								 CURLOPT_POST => false,
								 CURLOPT_SSL_VERIFYHOST => false,
								 CURLOPT_SSL_VERIFYPEER => false,
								 CURLOPT_RETURNTRANSFER => true);

			  if ($headers) { $curl_opts[CURLOPT_HTTPHEADER] = $headers; }
			 
			  $response = do_curl($curl_opts);
			  
			  if (! empty($response)) { $retarr = $response; }
			  
			  return $retarr;
			}

			/**
			 * Do an HTTP POST
			 * @param string $url
			 * @param int $port (optional)
			 * @param array $headers an array of HTTP headers (optional)
			 * @return array ($info, $header, $response) on success or empty array on error.
			 */
			function do_post($url, $postbody, $port=80, $headers=NULL)
			{
			  $retarr = array();  // Return value

			  $curl_opts = array(CURLOPT_URL => $url,
								 CURLOPT_PORT => $port,
								 CURLOPT_POST => true,
								 CURLOPT_SSL_VERIFYHOST => false,
								 CURLOPT_SSL_VERIFYPEER => false,
								 CURLOPT_POSTFIELDS => $postbody,
								 CURLOPT_RETURNTRANSFER => true);

			  if ($headers) { $curl_opts[CURLOPT_HTTPHEADER] = $headers; }

			  $response = do_curl($curl_opts);

			  if (! empty($response)) { $retarr = $response; }

			  return $retarr;
			}

			/**
			 * Make a curl call with given options.
			 * @param array $curl_opts an array of options to curl
			 * @return array ($info, $header, $response) on success or empty array on error.
			 */
			function do_curl($curl_opts)
			{
			  global $debug;
			  
			  $retarr = array();  // Return value
			 
			  if (! $curl_opts) {
				if ($debug) { logit("do_curl:ERR:curl_opts is empty"); }
				return $retarr;
			  }

			 
			  // Open curl session
			  $ch = curl_init();
			   
			  if (! $ch) {
				if ($debug) { logit("do_curl:ERR:curl_init failed"); }
				return $retarr;
			  }
			 
			  // Set curl options that were passed in
			  curl_setopt_array($ch, $curl_opts);

			  // Ensure that we receive full header
			  curl_setopt($ch, CURLOPT_HEADER, true);

			  if ($debug) {
				curl_setopt($ch, CURLINFO_HEADER_OUT, true);
				curl_setopt($ch, CURLOPT_VERBOSE, true);
			  }

			  // Send the request and get the response
			  ob_start();
			  $response = curl_exec($ch);
			  $curl_spew = ob_get_contents();
			  ob_end_clean();
			  if ($debug && $curl_spew){
				logit("do_curl:INFO:curl_spew begin");
				logit($curl_spew, false);
				logit("do_curl:INFO:curl_spew end");
			  }

			  // Check for errors
			  if (curl_errno($ch)) {
				$errno = curl_errno($ch);
				$errmsg = curl_error($ch);
				if ($debug) { logit("do_curl:ERR:$errno:$errmsg"); }
				curl_close($ch);
				unset($ch);
				return $retarr;
			  }

			  if ($debug) {
				logit("do_curl:DBG:header sent begin");
				$header_sent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
				logit($header_sent, false);
				logit("do_curl:DBG:header sent end");
			  }

			  // Get information about the transfer
			  $info = curl_getinfo($ch);

			  // Parse out header and body
			  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			  $header = substr($response, 0, $header_size);
			  $body = substr($response, $header_size );

			  // Close curl session
			  curl_close($ch);
			  unset($ch);

			  if ($debug) {
				logit("do_curl:DBG:response received begin");
				if (!empty($response)) { logit($response, false); }
				logit("do_curl:DBG:response received end");
			  }

			  // Set return value
			  array_push($retarr, $info, $header, $body);

			  return $retarr;
			}

			/**
			 * Pretty print some JSON
			 * @param string $json The packed JSON as a string
			 * @param bool $html_output true if the output should be escaped
			 * (for use in HTML)
			 * @link http://us2.php.net/manual/en/function.json-encode.php#80339
			 */
			function json_pretty_print($json, $html_output=false)
			{
			  $spacer = '  ';
			  $level = 1;
			  $indent = 0; // current indentation level
			  $pretty_json = '';
			  $in_string = false;

			  $len = strlen($json);

			  for ($c = 0; $c < $len; $c++) {
				$char = $json[$c];
				switch ($char) {
				case '{':
				case '[':
				  if (!$in_string) {
					$indent += $level;
					$pretty_json .= $char . "\n" . str_repeat($spacer, $indent);
				  } else {
					$pretty_json .= $char;
				  }
				  break;
				case '}':
				case ']':
				  if (!$in_string) {
					$indent -= $level;
					$pretty_json .= "\n" . str_repeat($spacer, $indent) . $char;
				  } else {
					$pretty_json .= $char;
				  }
				  break;
				case ',':
				  if (!$in_string) {
					$pretty_json .= ",\n" . str_repeat($spacer, $indent);
				  } else {
					$pretty_json .= $char;
				  }
				  break;
				case ':':
				  if (!$in_string) {
					$pretty_json .= ": ";
				  } else {
					$pretty_json .= $char;
				  }
				  break;
				case '"':
				  if ($c > 0 && $json[$c-1] != '\\') {
					$in_string = !$in_string;
				  }
				default:
				  $pretty_json .= $char;
				  break;
				}
			  }

			  return ($html_output) ?
				'<pre>' . htmlentities($pretty_json) . '</pre>' :
				$pretty_json . "\n";
			}

			 function callcontact_yahoo($consumer_key, $consumer_secret, $guid, $access_token, $access_token_secret, $usePost=false, $passOAuthInHeader=true)
			{
			  $retarr = array();  // return value
			  $response = array();
					
			  $url = 'https://social.yahooapis.com/v1/user/' . $guid . '/contacts;count=1000';
			  $params['format'] = 'json';
			  $params['view'] = 'compact';
			  $params['oauth_version'] = '1.0';
			  $params['oauth_nonce'] = mt_rand();
			  $params['oauth_timestamp'] = time();
			  $params['oauth_consumer_key'] = $consumer_key;
			  $params['oauth_token'] = $access_token;

			  // compute hmac-sha1 signature and add it to the params list
			  $params['oauth_signature_method'] = 'HMAC-SHA1';
			  $params['oauth_signature'] =
				  oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
										 $consumer_secret, $access_token_secret);

			  // Pass OAuth credentials in a separate header or in the query string
			  if ($passOAuthInHeader) {
				$query_parameter_string = oauth_http_build_query($params, true);
				$header = build_oauth_header($params, "yahooapis.com");
				$headers[] = $header;
			  } else {
				$query_parameter_string = oauth_http_build_query($params);
			  }

			  // POST or GET the request
			  if ($usePost) {
				$request_url = $url;
				logit("callcontact:INFO:request_url:$request_url");
				logit("callcontact:INFO:post_body:$query_parameter_string");
				$headers[] = 'Content-Type: application/x-www-form-urlencoded';
				$response = do_post($request_url, $query_parameter_string, 443, $headers);
			  } else {
				$request_url = $url . ($query_parameter_string ?
									   ('?' . $query_parameter_string) : '' );
				logit("callcontact:INFO:request_url:$request_url");
				$response = do_get($request_url, 443, $headers);
			  }
			  $yahoo_array = array();
			  /*$newList	= "<table>
							<tr><td>Name </td><td>Email </td><td><a href='javascript:;' class='select_bt'>Select All</a>/<a href='javascript:;' class='clear_bt'>Clear All</a></td>
							</tr>";*/
				$newList = "";
			  // extract successful response
			  if (! empty($response)) {
				list($info, $header, $body) = $response;
				if ($body) {
				  //logit("callcontact:INFO:response:");
				  //print(json_pretty_print($body));
				  $yahoo_array = json_decode($body);
				  
				 echo "<pre/>";
				 print_r($yahoo_array);
				 foreach($yahoo_array as $key=>$values){
					 
					 
					 foreach($values->contact as $keys=>$values_sub){
						// echo '<pre/>';
						// print_r($values_sub);
						 //echo $values_sub->fields[1]->value->givenName;
						 $email = $values_sub->fields[2]->value.":".$values_sub->fields[0]->value->givenName;
						 
						if(trim($email)!="")
						$newList   .= $email.",";
						
					 }
				 }
				  
				}
				$retarr = $newList."";
			  }

			  return $retarr;
			}
			function get_access_token_yahoo($consumer_key, $consumer_secret, $request_token, $request_token_secret, $oauth_verifier, $usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=true)
			{
			  $retarr = array();  // return value
			  $response = array();
			  $url = 'https://api.login.yahoo.com/oauth/v2/get_token';
			  $params['oauth_version'] = '1.0';
			  $params['oauth_nonce'] = mt_rand();
			  $params['oauth_timestamp'] = time();
			  $params['oauth_consumer_key'] = $consumer_key;
			  $params['oauth_token']= $request_token;
			  $params['oauth_verifier'] = $oauth_verifier;

			  // compute signature and add it to the params list
			  if ($useHmacSha1Sig) {
				$params['oauth_signature_method'] = 'HMAC-SHA1';
				$params['oauth_signature'] =
				  oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
										 $consumer_secret, $request_token_secret);
			  } else {
				$params['oauth_signature_method'] = 'PLAINTEXT';
				$params['oauth_signature'] =
				  oauth_compute_plaintext_sig($consumer_secret, $request_token_secret);
			  }

			  // Pass OAuth credentials in a separate header or in the query string
			  if ($passOAuthInHeader) {
				$query_parameter_string = oauth_http_build_query($params, false);
				$header = build_oauth_header($params, "yahooapis.com");
				$headers[] = $header;
			  } else {
				$query_parameter_string = oauth_http_build_query($params);
			  }

			  // POST or GET the request
			  if ($usePost) {
				$request_url = $url;
				logit("getacctok:INFO:request_url:$request_url");
				logit("getacctok:INFO:post_body:$query_parameter_string");
				$headers[] = 'Content-Type: application/x-www-form-urlencoded';
				$response = do_post($request_url, $query_parameter_string, 443, $headers);
			  } else {
				$request_url = $url . ($query_parameter_string ?
									   ('?' . $query_parameter_string) : '' );
				logit("getacctok:INFO:request_url:$request_url");
				$response = do_get($request_url, 443, $headers);
			  }

			  // extract successful response
			  if (! empty($response)) {
				list($info, $header, $body) = $response;
				$body_parsed = oauth_parse_str($body);
				if (! empty($body_parsed)) {
				  logit("getacctok:INFO:response_body_parsed:");
				 // print_r($body_parsed);
				}
				$retarr = $response;
				$retarr[] = $body_parsed;
			  }

			  return $retarr;
			}

			/* Function added for getting the request token */

			function get_request_token($consumer_key, $consumer_secret, $callback, $usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=false)
			{
					
			  $retarr = array();  // return value
			  $response = array();

			  $url = 'https://api.login.yahoo.com/oauth/v2/get_request_token';
			  $params['oauth_version'] = '1.0';
			  $params['oauth_nonce'] = mt_rand();
			  $params['oauth_timestamp'] = time();
			  $params['oauth_consumer_key'] = $consumer_key;
			  $params['oauth_callback'] = $callback;

			  // compute signature and add it to the params list
			  if ($useHmacSha1Sig) {
				$params['oauth_signature_method'] = 'HMAC-SHA1';
				$params['oauth_signature'] =
				  oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
										 $consumer_secret, null);
			  } else {
				$params['oauth_signature_method'] = 'PLAINTEXT';
				$params['oauth_signature'] =
				  oauth_compute_plaintext_sig($consumer_secret, null);
			  }

			  // Pass OAuth credentials in a separate header or in the query string
			  if ($passOAuthInHeader) {
				  
				$query_parameter_string = oauth_http_build_query($params, FALSE);
				
				$header = build_oauth_header($params, "yahooapis.com");
				$headers[] = $header;
			  } else {
				$query_parameter_string = oauth_http_build_query($params);
			  }
			 
			  // POST or GET the request
			  if ($usePost) {
				$request_url = $url;
				logit("getreqtok:INFO:request_url:$request_url");
				logit("getreqtok:INFO:post_body:$query_parameter_string");
				$headers[] = 'Content-Type: application/x-www-form-urlencoded';
				$response = do_post($request_url, $query_parameter_string, 443, $headers);
			  } else {
				$request_url = $url . ($query_parameter_string ?
									   ('?' . $query_parameter_string) : '' );
				 
				logit("getreqtok:INFO:request_url:$request_url");
				
				$response = do_get($request_url, 443, $headers);
				
			  }
			  
			  // extract successful response
			  if (! empty($response)) {
				list($info, $header, $body) = $response;
				$body_parsed = oauth_parse_str($body);
				if (! empty($body_parsed)) {
				  logit("getreqtok:INFO:response_body_parsed:");
				  //print_r($body_parsed);
				}
				$retarr = $response;
				$retarr[] = $body_parsed;
			  }

			  return $retarr;
			}
	}
?>
