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

use App\Larapen\Events\ReportAbuseWasSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailReportAbuse extends Email
{
    /**
     * Handle the event.
     *
     * @param  ReportAbuseWasSent $event
     * @return void
     */
    public function handle(ReportAbuseWasSent $event)
    {
        try {
            Mail::send('emails.ad.abuse', ['ad' => $event->ad, 'report_abuse' => $event->report_abuse], function ($m) use ($event) {
                $m->from($event->report_abuse->email, $event->report_abuse->email);
                $m->to(config('settings.app_email'), config('settings.app_name'))->subject(trans('mail.New abuse report', [
                    'app_name' => config('settings.app_name'),
                    'country_code' => $event->ad->country_code
                ]));
            });
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }
}
