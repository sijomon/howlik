<?php
namespace App\Larapen\Helpers;

use App\Larapen\Models\Ad;
use App\Larapen\Models\Category;
use App\Larapen\Models\Pack;
use App\Larapen\Models\PaymentMethod;
use Illuminate\Http\Request;

class Rules
{
    public static $packs;
    public static $payment_methods;

    public static function Business(Request $request, $method)
    {
        $rules = [];
        
        // Create
        if (in_array($method, ['POST', 'CREATE'])) {
            $rules = [
				'category_id' => 'required|not_in:0',
				'title' => 'required|between:5,200',
				'description' => 'required|between:5,3000',
				'phone' => 'required|between:3,200',
				'address1' => 'required',
				'location' => 'required|not_in:0',
				'city' => 'required',
            ];
            
            // Require 'pictures' if exists
            if ($request->file('pictures')) {
                $files = $request->file('pictures');
				$vF = 0;$vFkey = 'x';
                foreach ($files as $key => $file) {
                    if (!is_null($file)) {
                        $rules['pictures.' . $key] = 'required|image|mimes:jpeg,jpg,png';
						$vF = 1;
						if($vFkey == 'x')$vFkey = $key;
                    }
                }
				if($vF == 0){
					$rules['pictures.' . $vFkey] = 'required|image|mimes:jpeg,jpg,png';
				}
            }
            
            // Recaptcha
            if (config('settings.activation_recaptcha')) {
                $rules['g-recaptcha-response'] = 'required';
            }
        }
        
        // Update
        if (in_array($method, ['PUT', 'PATCH', 'UPDATE'])) {
            $rules = [
                'category_id' => 'required|not_in:0',
				'title' => 'required|between:5,200',
				'description' => 'required|between:5,3000',
				'phone' => 'required|between:3,200',
				'address1' => 'required',
				'location' => 'required|not_in:0',
				'city' => 'required',
            ];
            
            // Require 'pictures' if exists
            if ($request->file('pictures')) {
				$pic_delA = $request->input('pic_del');
                $files = $request->file('pictures');
                $vF = 0;$vFkey = 'x';
				foreach ($files as $key => $file) {
					if($pic_delA[$key]>2)$vF = 1;
                    if (!is_null($file)) {
                        $rules['pictures.' . $key] = 'required|image|mimes:jpeg,jpg,png';
						$vF = 1;
						if($vFkey == 'x')$vFkey = $key;
                    }
                }
				if($vF == 0){
					$rules['pictures.' . $vFkey] = 'required|image|mimes:jpeg,jpg,png';
				}
            }
            
        }
        
        //dd($rules);
        
        return $rules;
    }
    
    public static function Signup(Request $request)
    {
        $rules = [
            'gender' => 'required|not_in:0',
            'name' => 'required|mb_between:3,200',
            'user_type' => 'required|not_in:0',
            'country' => 'sometimes|required|not_in:0',
            'phone' => 'sometimes|required|min:3|max:20',
            'email' => 'required|email|unique:users,email|whitelist_email|whitelist_domain',
            'password' => 'required|between:5,15|confirmed',
            //'password' => 'required|between:5,15', // @todo: delete this rule
            'g-recaptcha-response' => (config('settings.activation_recaptcha')) ? 'required' : '',
            'term' => 'accepted',
        ];
        
        return $rules;
    }
    
    public static function Login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:5|max:50',
        ];
        
        return $rules;
    }
    
    public static function ContactUs(Request $request)
    {
        $rules = [
            'first_name' => 'required|mb_between:2,100',
            'last_name' => 'required|mb_between:2,100',
            'email' => 'required|email|whitelist_email|whitelist_domain',
            'message' => 'required|mb_between:5,500',
            'g-recaptcha-response' => (config('settings.activation_recaptcha')) ? 'required' : '',
        ];
        
        return $rules;
    }
    
    public static function Message(Request $request)
    {
        $rules = [
            'sender_name' => 'required|mb_between:3,200',
            'sender_email' => 'required|email|max:100',
            'sender_phone' => 'required|max:50',
            'message' => 'required|mb_between:20,500',
            'g-recaptcha-response' => (config('settings.activation_recaptcha')) ? 'required' : '',
            'ad' => 'required|numeric',
        ];
        
        return $rules;
    }
    
    public static function Report(Request $request)
    {
        $rules = [
            'report_type' => 'required|not_in:0',
            'report_sender_email' => 'required|email|max:100',
            'report_message' => 'required|mb_between:20,500',
            'ad' => 'required|numeric',
            // @fixme : multi-captcha on the same page
            //'g-recaptcha-response'  => (config('settings.activation_recaptcha')) ? 'required' : '',
        ];
        
        return $rules;
    }
	
	public static function EventMsg(Request $request)
	{
		$messages = [
		
			'event_type_id.required' => 'The event type field is required.'
		];
		
		return $messages;
	}
	
	public static function Event(Request $request)
	{
		
		$rules = [
		
			'event_title'		=>	'required|max:30',
			//'subadmin1_code'	=>	'required',
			//'event_place'		=>	'required',
			'startDate'			=>	'required',
			'endDate'			=>	'required',
			'event_description'	=>	'required',
			'event_type_id'		=>	'required'
		];
		
		if ($request->has('ticket_type')) {
			
			if ($request->input('ticket_type')==1) {
				
				$rules['free_tickets'] = 'required|numeric|min:1|max:9999999999';
			}elseif ($request->input('ticket_type')==2) {
				
				$rules['paid_tickets'] = 'required|numeric|min:1|max:9999999999';
				$rules['ticket_price'] = 'required|numeric|min:1|max:9999999999';
			}
		}
		return $rules;
	}	
	
	public static function Offer(Request $request)
	{
		
		$rules 	= [
		
			'offer_title'		=>	'required',
			'offer_location'	=>	'required',
			'percentage'		=>	'required',
			'company_name'		=>	'required',
			'company_url'		=>	'required'
		];
		
		return $rules;
	}
}
