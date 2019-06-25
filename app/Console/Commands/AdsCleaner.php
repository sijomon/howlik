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

namespace App\Console\Commands;

use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Carbon\Carbon;
use App\Larapen\Events\AdWasArchived;
use App\Larapen\Events\AdWasDeleted;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Country;
use App\Larapen\Models\TimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class AdsCleaner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:clean';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all old ads.';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all Countries
        $countries = Country::withoutGlobalScope(ActiveScope::class)->all();
        
        foreach ($countries as $country) {
            $today = Carbon::now(TimeZone::find($country->code)->time_zone_id);
            $ads = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('country_code', $country->code);
            
            if ($ads->count() <= 0) {
                $this->info('No ads in "' . $country->name . '" (' . strtolower($country->code) . ') website.');
                continue;
            }
            
            // Get all Ads
            $ads = $ads->get();
            
            foreach ($ads as $ad) {
                // Non-activated Ads
                if ($ad->active != 1) {
                    if ($ad->created_at->addMonth() >= $today) {
                        // Delete non-active Ads after 1 month
                        $ad->delete();
                        continue;
                    }
                } // Activated Ads
                else {
                    // SuperAdmin's Ads
                    if (isset($ad->user_id) and $ad->user_id == 1) {
                        if ($ad->created_at->addMonth() >= $today) {
                            // Delete all SuperAdmin Ads after 1 month
                            $ad->delete();
                            continue;
                        }
                    } // Users's Ads
                    else {
                        // Auto-archive
                        if ($ad->archived != 1) {
                            // Archive all activated ads after 5 months
                            if ($ad->created_at->addMonths(5) >= $today) {
                                // Archive
                                $ad->archived = 1;
                                $ad->save();

                                if ($country->active == 1) {
                                    // Send an Email confirmation
                                    Event::fire(new AdWasArchived($ad));
                                }

                                continue;
                            }
                        }
                        
                        // Auto-delete
                        if ($ad->archived == 1) {
                            if ($ad->created_at->addMonth()->subWeek() >= $today) {
                                // @todo: Alert user 1 week later
                            }
                            
                            if ($ad->created_at->addMonth()->subDay() >= $today) {
                                // @todo: Alert user 1 day later
                            }
                            
                            // Delete all archived ads 1 month later
                            if ($ad->updated_at->addMonth() >= $today) {
                                if ($country->active == 1) {
                                    // Send an Email confirmation
                                    Event::fire(new AdWasDeleted($ad));
                                }

                                // Delete
                                $ad->delete();

                                continue;
                            }
                        }
                    }
                }
            }
        }
    }
}
