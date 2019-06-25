<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\FrontController;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Business;
use App\Larapen\Models\SavedAd;
use App\Larapen\Models\SavedSearch;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\View;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

abstract class AccountBaseController extends FrontController
{
    public $countries;
    public $my_business;
    public $archived_business;
    public $favourite_ads;
    public $pending_business;

    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*$this->countries = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        View::share('countries', $this->countries);
		
		$this->country = Country::trans($this->country, $this->lang->get('abbr'));
        View::share('country', $this->country);
        
        // My Business
        $this->my_business = Business::where('user_id', $this->user->id)->active()->with('city')->take(50)->orderBy('created_at', 'DESC');
        View::share('count_my_business', $this->my_business->count());
        
        // Archived Ads
        //$this->archived_business = Business::where('user_id', $this->user->id)->archived()->with('city')->take(50)->orderBy('created_at', 'DESC');
        //View::share('count_archived_business', $this->archived_business->count());
        
        // Favourite Ads
        $this->favourite_ads = SavedAd::where('user_id', $this->user->id)->with('ad.city')->take(50)->orderBy('created_at', 'DESC');
        View::share('count_favourite_ads', $this->favourite_ads->count());
        
        // Pending Approval Business
        $this->pending_business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id',
            $this->user->id)->pending()->with('city')->take(50)->orderBy('created_at', 'DESC');
        View::share('count_pending_business', $this->pending_business->count());
        
        // Save Search
        $saved_search = SavedSearch::where('user_id', $this->user->id)->orderBy('created_at', 'DESC');
        View::share('count_saved_search', $saved_search->count());*/
    }
}
