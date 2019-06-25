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

use App\Larapen\Events\MessageWasSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailMessageToAdvertiser extends Email
{
    /**
     * Handle the event.
     *
     * @param  MessageWasSent $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        try {
            Mail::send('emails.ad.message', ['ad' => $event->ad, 'msg' => $event->message], function ($m) use ($event) {
                $m->to($event->ad->seller_email, $event->ad->seller_name)->replyTo($event->message->email,
                    $event->message->name)->subject(trans('mail.Your ad ":title" on :app_name', [
                    'title' => $event->ad->title,
                    'app_name' => config('settings.app_name')
                ]));
            });
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }
}
