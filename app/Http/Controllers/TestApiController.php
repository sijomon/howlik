<?php 

	namespace App\Http\Controllers;

	use Illuminate\Support\Facades\View;
	use Torann\LaravelMetaTags\Facades\MetaTag;
	use Illuminate\Support\Facades\Request as Request;
	use Illuminate\Http\Request as HttpRequest;
	use Illuminate\Support\Facades\DB;
	use App\Larapen\Models\Connect;

	class TestApiController extends FrontController
	{
		// check email and device exist
		public function existOrNot(HttpRequest $request)  
		{
			
			if(Request::has('email') && Request::has('device')) {
				
				$email	  =	Request::get('email');
				$device   =	Request::get('device');
				
				$tableArr = Connect::where('email', $email)->first();
			
				// if email exist update details
				if(!empty($tableArr)) {
					
					$deviceArr = unserialize($tableArr->devices);
					
					if (!in_array($device, $deviceArr)) {
						
						array_push($deviceArr, $device);
						$details = array (
					
							'devices' => serialize($deviceArr),
						);
						$tableArr->update($details);
					}
					$result = 	array(
								'status' => 'success',
								'response' => 'successful'
							);			
					return json_encode($result);
					exit;                  
				}
				// if email not exist save details
				else if(empty($tableArr)) {
					
					$deviceArr = array();
					array_push($deviceArr, $device);
					
					$details = array (
					
						'email' => $email,
						'devices' => serialize($deviceArr),
					);

					// Save Business to database
					$connectArr = new Connect($details);
					$connectArr->save();
					$result = 	array(
								'status' => 'success',
								'response' => 'successful'
							);			
					return json_encode($result);
					exit;                  
				}
			}
			else {
				
				$result = 	array(
							'status' => 'failure',
							'response' => 'unsuccessful'
						);			
				return json_encode($result);
				exit;                  
			}
		}
		
		// give the list of devices in accessed
		public function ifNeedList(HttpRequest $request)  
		{
			// $email	  =	'sreeharis@shrishtionline.com';
			
			if(Request::has('email')) {
			// if($email) {
				
				$email	  =	Request::get('email');
				$tableArr = Connect::where('email', $email)->first();
				
				// if email exist update details
				if(!empty($tableArr)) {
					
					$deviceArr = unserialize($tableArr->devices);
					
					$result = 	array(
									'status' => 'success',
									'response' => $deviceArr
								);			
					return json_encode($result);
					exit;   
				}
				else {
				
					$result = 	array(
								'status' => 'failure',
								'response' => 'unsuccessful'
							);			
					return json_encode($result);
					exit;
				}
			}
			else {
				
				$result = 	array(
							'status' => 'failure',
							'response' => 'unsuccessful'
						);			
				return json_encode($result);
				exit;
			}
		}
	}