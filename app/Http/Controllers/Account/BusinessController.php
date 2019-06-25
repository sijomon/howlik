<?php

namespace App\Http\Controllers\Account;

use App\Larapen\Events\BusinessWasDeleted;
use App\Larapen\Helpers\Arr;
use App\Larapen\Helpers\Search;
use App\Larapen\Models\User;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessBookingOrder;
use App\Larapen\Models\Category;
//use App\Larapen\Models\SavedAd;
//use App\Larapen\Models\SavedSearch;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Session;

class BusinessController extends AccountBaseController
{
    public function getMyBusiness()
    {
        $data = array();
        $data['business'] = $this->my_business->get();
        $data['type'] = 'mybusiness';
        
        // Meta Tags
        MetaTag::set('title', t('My business'));
        MetaTag::set('description', t('My business on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.business', $data);
    }
	
	public function getMyBusinessBooking($id)
    {
		
        $data = array();
        $data['business'] = $this->my_business->where('user_id',$this->user->id)->find($id);
		
        $data['type'] = 'mybusinessbooking';
		if(!(isset($data['business']->id) && $data['business']->id>0)){
			//flash()->error(t('Sorry! You have requested an invalid URL.'));
			return redirect($this->lang->get('abbr') . '/account');
		}
		$user_id = $this->user->id;
		$query = DB::table('businessBookingOrder as bk');
		$query->select('bk.*', 'b.title', 'b.title_ar', 'b.country_code', 'c.name as ciname', 'c.asciiname as ciasciiname');
		$query->join('business as b','b.id','=','bk.biz_id');
		$query->join('cities as c','c.id','=','b.city_id');
		$query->where('b.user_id', $user_id);
		$query->where('b.id', $id);
		/*$query->whereIn('bk.biz_id', function($subquery) use ($user_id){
							$subquery->select('id')
								  ->from('business')
								  ->where('business.user_id', $user_id);
						});*/
		$query->orderBy('bk.created_at','desc');
		$data['booking'] = $query->paginate(12);
		
		//echo "<pre>";print_r($data['booking']);exit;
		
		if (Request::ajax()) {
            //return Response::json(View::make('classified.account.businessbookingajax', $data)->render());
			return view('classified.account.businessbookingajax', $data);
        }
        // Meta Tags
        MetaTag::set('title', t('My business bookings'));
        MetaTag::set('description', t('My business bookings on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.businessbooking', $data);
    }
	
	public function getMyBusinessOrders()
    {
        $data = array();
        $data['type'] = 'mybusinessorders';
		
		$user_id = $this->user->id;
		$query = DB::table('businessBookingOrder as bk');
		$query->select('bk.*', 'b.title', 'b.title_ar', 'b.country_code', 'c.name as ciname', 'c.asciiname as ciasciiname');
		$query->join('business as b','b.id','=','bk.biz_id');
		$query->join('cities as c','c.id','=','b.city_id');
		$query->where('bk.user_id', $user_id);
		/*$query->whereIn('bk.biz_id', function($subquery) use ($user_id){
							$subquery->select('id')
								  ->from('business')
								  ->where('business.user_id', $user_id);
						});*/
		$query->orderBy('bk.created_at','desc');				
		$book = $query->get();
		$data['booking'] = $query->paginate(12);
		
		if (Request::ajax()) {
			//echo "<pre>";print_r($data['booking']);die;
            //return Response::json(View::make('classified.account.businessorderajax', $data)->render());
			return view('classified.account.businessorderajax', $data);
        }
        // Meta Tags
        MetaTag::set('title', t('My business orders'));
        MetaTag::set('description', t('My business orders on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.businessorder', $data);
    }
	
	public function book_action(HttpRequest $request)
    {
		$id 	= $request->input('id');
		$status = $request->input('status');
		$btb 	= BusinessBookingOrder::where('id', $id)->first();
		$btb->approved = $status;
		$btb->save();
		if($status==1){
			$statusT	= t('Approved');
			$res = '<span class="btn-bg-green">'.t('Approved').'</span>';
			$statusCls = 'btn-oprtn';
		}else{
			$statusT	= t('Discarded');
			$res = '<span class="btn-bg-red">'.t('Discarded').'</span>';
			$statusCls = 'btn-oprtn-r';
		}
		
		/* BOF Notification email to user */
		$biz_id   = $btb->biz_id;
		$business = Business::where('id', $biz_id)->first();
		$user 	  = User::select('name', 'email')->where('id', $btb->user_id)->first();
		$subject  = trans('mail.Howlik: Business reservation status').' '.date('m/d/Y h:i A', time());
		$pass['subject'] = $subject;
		$pass['email']   = $user->email;
		$pass['name']    = $user->name;
		$link    		 =   "/".str_replace(' ', '-', $business->title)."/".$business->id.".html";
		
		$template['status']   	 = $statusT;
		$template['user']     	 = $user->name;
		$template['biz_link'] 	 = "<a href='".lurl($link)."' target='_blank'>".$business->title."</a>";
		$template['your_orders'] = "<a href='".lurl('account/mybusinessorders')."' target='_blank'>".trans('mail.Your Orders')."</a>";
		$template['site_url']    = "<a href='".lurl('/')."' target='_blank'>Howlik.com</a>";
		
		Mail::send('emails.business.bookingapproval', ['title' => $subject, 'template' => $template], function ($m) use ($pass) {
			$m->to($pass['email'], $pass['name'])->subject($pass['subject']);
		});
		/* EOF Notification email to business user */
		
		$reply['btn'] = '<button class="btn '.$statusCls.'"> '.$statusT.' </button>';
		$reply['res'] = $res;
		return json_encode($reply);	
	}
    
    public function getArchivedAds(HttpRequest $request)
    {
        // If repost
        if ($request->segment(4) == 'repost') {
            $id = $request->segment(5);
            $res = false;
            if (is_numeric($id) and $id > 0) {
                $res = Ad::find($id)->update(['archived' => 0]);
            }
            if (!$res) {
                flash()->error(t("The repost has failed. Please try again."));
            } else {
                flash()->success(t("The repost has done successfully."));
            }
            
            return redirect($this->lang->get('abbr') . '/account/' . $request->segment(3));
        }
        
        $data = array();
        $data['ads'] = $this->archived_ads->get();
        
        // Meta Tags
        MetaTag::set('title', t('My archived ads'));
        MetaTag::set('description', t('My archived ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getFavouriteAds()
    {
        $data = array();
        $data['ads'] = $this->favourite_ads->get();
        
        // Meta Tags
        MetaTag::set('title', t('My favourite ads'));
        MetaTag::set('description', t('My favourite ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.ads', $data);
    }
    
    public function getPendingApproval()
    {
        $data = array();
        $data['business'] = $this->pending_business->get();
        
        // Meta Tags
        MetaTag::set('title', t('My pending approval ads'));
        MetaTag::set('description', t('My pending approval ads on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.business', $data);
    }
    
    public function getSavedSearch(HttpRequest $request)
    {
        $data = array();
        
        // Get QueryString
        $tmp = parse_url(qsurl(Request::url(), Request::all()));
        $query_string = (isset($tmp['query']) ? $tmp['query'] : 'false');
        
        // CATEGORIES COLLECTION
        $cats = Category::where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $cats = collect($cats)->keyBy('translation_of');
        View::share('cats', $cats);
        
        // Search
        $saved_search = SavedSearch::where('user_id', $this->user->id)->orderBy('created_at', 'DESC')->get();
        
        if (collect($saved_search)->keyBy('query')->keys()->contains($query_string)) {
            if (!is_null($saved_search) and count($saved_search) > 0) {
                $search = new Search($request, $this->country, $this->lang);
                $data = $search->fechAll();
            }
        }
        $data['saved_search'] = $saved_search;
        
        // Meta Tags
        MetaTag::set('title', t('My saved search'));
        MetaTag::set('description', t('My saved search on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account.saved-search', $data);
    }
    
    public function delete(HttpRequest $request)
    {
        // Get Entries ID
        $ids = [];
        if ($request->has('biz')) {
            $ids = $request->get('biz');
        } else {
            $id = $request->segment(5);
            if (!is_numeric($id) and $id <= 0) {
                $ids = [];
            } else {
                $ids[] = $id;
            }
        }
        
        // Delete
        $nb = 0;
        if ($request->segment(3) == 'favourite') {
            $saved_ads = SavedAd::where('user_id', $this->user->id)->whereIn('ad_id', $ids);
            if (!is_null($saved_ads)) {
                $nb = $saved_ads->delete();
            }
        } elseif ($request->segment(3) == 'saved-search') {
            $nb = SavedSearch::destroy($ids);
        } else {
            foreach ($ids as $id) {
                $biz = Business::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->find($id);
				/*echo "<pre>";
				print_r($biz);*/
				
				/*print_r($tmp_biz);
				exit;*/
                if (!is_null($biz)) {
                    $t_biz = $biz->toArray();
					$t_biz['user_email'] = $biz->user->email;
					$t_biz['user_name'] = $biz->user->name;
					$tmp_biz = Arr::toObject($t_biz);
                    
                    // Delete Business
                    $nb = $biz->delete();
                    
                    // Send an Email confirmation
                    Event::fire(new BusinessWasDeleted($tmp_biz));
                }
            }
        }
        
        // Confirmation
        if ($nb == 0) {
            flash()->error(t("No deletion is done. Please try again."));
        } else {
            $count = count($ids);
            if ($count > 1) {
                flash()->success(t("x businesses has been deleted successfully.", ['count' => $count]));
            } else {
                flash()->success(t("1 business has been deleted successfully."));
            }
        }
        
        return redirect($this->lang->get('abbr') . '/account/' . $request->segment(3));
    }
}
