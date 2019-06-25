<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

use App\Larapen\Events\EventWasVisited;
use App\Larapen\Models\EventVisit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use App\Larapen\Helpers\Ip;
use DB;
use Carbon;

class UpdateTheEventCounter
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
     * @param  EventWasVisited $event
     * @return void
     */
    public function handle(EventWasVisited $event)
    {
        // Don't count the self-visits
        if (Auth::check()) {
            if (Auth::user()->id == $event->events->user_id) {
                return false;
            }
        }
		
		$visit	=	DB::table('event_visits')->select('created_at')->where('event_id', $event->events->id)->where('ip_address', Ip::get())->orderBy('created_at', 'DESC')->first();
		
		if(!empty($visit)) {
			$now 		=	strtotime(Carbon\Carbon::now());			
			$past		=	strtotime($visit->created_at);
			$diff		=	round(abs($now - $past) / 60);
		}
		if(empty($visit) || $diff > 59) {
			
			$event->events->visits = $event->events->visits + 1;
			$event->events->save();
			
			$country_code	=	strtoupper(CountryLocalization::getCountryCodeFromIP());
			
			$event->event_visit				  =	new EventVisit();
			$event->event_visit->event_id	  =	$event->events->id;
			$event->event_visit->ip_address	  =	Ip::get();
			$event->event_visit->country_code =	$country_code;
			$event->event_visit->save();
		}
        
    }
}
