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

use App\Larapen\Events\BusinessWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Prologue\Alerts\Facades\Alert;

class EmailBusinessActivation extends Email
{
    /**
     * Handle the event.
     *
     * @param  BusinessWasPosted $event
     * @return void
     */
    public function handle(BusinessWasPosted $event)
    {
        try {
            Mail::send('emails.business.activation', ['business' => $event->business], function ($m) use ($event) {
                $m->to($event->business->user->email, $event->business->user->name)->subject(trans('mail.Activate your business ":title"', [
                    'title' => str_limit($event->business->title, 50)
                ]));
            });
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }
}
