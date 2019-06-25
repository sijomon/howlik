<?php
/**
 * LaraClassified - Geo Classified Business CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Larapen\Listeners;

use App\Larapen\Events\BusinessWasVisited;
use App\Larapen\Models\BusinessVisit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use App\Larapen\Helpers\Ip;
use Carbon;

class UpdateTheBusinessCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  BusinessWasVisited $event
     * @return void
     */
    public function handle(BusinessWasVisited $event)
    {
        // Don't count the self-visits
        if (Auth::check()) {
            if (Auth::user()->id == $event->business->user_id) {
                return false;
            }
        }
        
		$visit	=	\DB::table('business_visits')->select('created_at')->where('biz_id', $event->business->id)->where('ip_address', Ip::get())->orderBy('created_at', 'DESC')->first();
		
		if(!empty($visit)) {
			$now 		=	strtotime(Carbon\Carbon::now());			
			$past		=	strtotime($visit->created_at);
			$diff		=	round(abs($now - $past) / 60);
		}
		if(empty($visit) || $diff > 59) {
			
			$event->business->visits = $event->business->visits + 1;
			$event->business->save();
			
			$country_code	=	strtoupper(CountryLocalization::getCountryCodeFromIP());
			
			$event->business_visit				 =	new BusinessVisit();
			$event->business_visit->biz_id		 =	$event->business->id;
			$event->business_visit->ip_address	 =	Ip::get();
			$event->business_visit->country_code =	$country_code;
			$event->business_visit->save();
		}
    }
}
