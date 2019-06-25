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

namespace App\Larapen\Events;

use App\Events\Event;
use App\Larapen\Helpers\Arr;
use App\Larapen\Models\Ad;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReportAbuseWasSent extends Event
{
    use SerializesModels;
    
    public $ad;
    public $report_abuse;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, $report_abuse)
    {
        $this->ad = $ad;
        $this->report_abuse = (is_array($report_abuse)) ? Arr::toObject($report_abuse) : $report_abuse;
    }
    
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
