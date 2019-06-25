<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Events\UserWasRegistered;
use App\Larapen\Helpers\Ip;

use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessClaim;
use App\Larapen\Models\User;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessClaimRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessClaimRequest as UpdateRequest;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class BusinessClaimRequestController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\BusinessClaim",
        "entity_name" => "business claim request",
        "entity_name_plural" => "business claim requests",
        "route" => "admin/business-claim-request",
        "reorder" => false,
        "edit_permission" => false,
		"delete_permission" => false,
		"add_permission" => false,
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'biz_no',
                'label' => "#",
            ],
			[
                'name' => 'biz_images',
                'label' => "Business Claim Requests",
                'type' => 'image_approval',
            ],
        ],
        
        // *****
        // SPECIALS
        // *****
        "special" => ['type' => 'claim_approval' ],
		
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'biz_hours',
                'label' => "Biz Hours",
                'type' => 'image_approval',
            ],
        ],
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
	
	public function claimaction()
	{
		$id   	= Request::get('id');
		$status = Request::get('status');
		
        $entries = BusinessClaim::where('id', $id)->first();
		if(!empty($entries)){
			$business = Business::where('id', $entries->biz_id)->first();
			if($status==1){
				$extraA = unserialize($entries->extra_details);
				if(isset($entries->user_id) && $entries->user_id>0){
					$user_id = $entries->user_id;
				}else{
					$pemail = trim($entries->pemail);
					if($pemail==''){
						$pemail = trim($entries->email);
					}
					$user = User::where('email', $pemail)->first();
					if(!isset($user->id)){
						$userInfo = array(
							'country_code'     => $entries->business->country_code,//$this->country->get('code') vin edit to fix country select
							'gender_id'        => $extraA['gender'],
							'name'             => $extraA['name'],
							'user_type_id'     => 2,
							'phone'            => $entries->phone,
							'email'            => $extraA['pemail'],
							'password'         => bcrypt($extraA['password']),
							'ip_addr'          => Ip::get(),
							'activation_token' => md5(uniqid()),
							'active'           => 1,
						);
						$user = new User($userInfo);
						$user->save();
						
						Event::fire(new UserWasRegistered($user));
					}
					$user_id = $user->id;
				}
				
				$user = User::where('id', $user_id)->first();
				$user->user_type_id = 2;
				$user->save();
				
				$business->category_id	= $entries->category_id;
				$business->user_id		= $user_id;
				$business->phone		= $entries->phone;
				$business->biz_email	= $entries->email;
				$business->address1		= $entries->address1;
				$business->address2		= $entries->address2;
				$business->zip			= $entries->zip;
				$business->subadmin1_code	= $entries->subadmin1_code;
				$business->city_id		= $entries->city_id;
				$business->lat			= $entries->lat;
				$business->lon			= $entries->lon;
				$business->save();
				
				$msDet['name'] = $user->name;
				$msDet['email'] = $user->email;
				$msDet['subject'] = "Your business claim request has been confirmed";
				$business['title'] = $business->title;
				$business['username'] = $msDet['name'];
				Mail::send('emails.business.claimconfirm', ['business' => $business], function ($m) use ($msDet) {
					$m->to($msDet['email'], mb_ucfirst($msDet['name']))->subject($msDet['subject']);
				});
			}elseif($status==3){
				$extraA = unserialize($entries->extra_details);
				if(isset($entries->user_id) && $entries->user_id>0){
					$user_id = $entries->user_id;
					$user = User::where('id', $user_id)->first();
					$msDet['name'] = $user->name;
					$msDet['email'] = $user->email;
				}else{
					$pemail = trim($entries->pemail);
					if($pemail==''){
						$pemail = trim($entries->email);
					}
					$msDet['name'] = $extraA['name'];
					$msDet['email'] = $pemail;
				}
				
				$msDet['subject'] = "Your business claim request has been rejected";
				$business['title'] = $business->title;
				$business['username'] = $msDet['name'];
				Mail::send('emails.business.claimreject', ['business' => $business], function ($m) use ($msDet) {
					$m->to($msDet['email'], mb_ucfirst($msDet['name']))->subject($msDet['subject']);
				});
			}
			$entries->delete();
		}
		echo json_encode (array( 'res' => $entries ));
	}
}