<?php

namespace App\Larapen\Listeners;

use App\Larapen\Events\BusinessWasDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailBusinessDeleteConfirmation extends Email
{
    /**
     * Handle the event.
     *
     * @param  BusinessWasDeleted $event
     * @return void
     */
    public function handle(BusinessWasDeleted $event)
    {
        // Don't send mail to Admin (if you want use crawler)
        if (isset($event->biz->user_id) and $event->biz->user_id == 1) {
            return false;
        }
        
        try {
            Mail::send('emails.business.delete', ['biz' => $event->biz], function ($m) use ($event) {
                $m->to($event->biz->user_email, $event->biz->user_name)->subject(trans('mail.Your business ":title" has been deleted', [
                    'title' => $event->biz->title
                ]));
            });
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }
}
