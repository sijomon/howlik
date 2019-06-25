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

use App\Larapen\Events\AdWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Prologue\Alerts\Facades\Alert;

class EmailAdActivation extends Email
{
    /**
     * Handle the event.
     *
     * @param  AdWasPosted $event
     * @return void
     */
    public function handle(AdWasPosted $event)
    {
        try {
            Mail::send('emails.ad.activation', ['ad' => $event->ad], function ($m) use ($event) {
                $m->to($event->ad->seller_email, $event->ad->seller_name)->subject(trans('mail.Activate your ad ":title"', [
                    'title' => str_limit($event->ad->title, 50)
                ]));
            });
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }
}
