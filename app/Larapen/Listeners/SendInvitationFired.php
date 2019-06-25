<?php

namespace App\Larapen\Listeners;

use App\Larapen\Events\SendInvitaion;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendInvitationFired
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
     * @param  SendInvitation  $event
     * @return void
     */
    public function handle(SendInvitaion $event)
    {
		
        $emails = str_replace('/','',$event->toaddress);
		
		//echo "<pre>";print_r($emails);die;
			Mail::send('emails.friends.invitation',[], function($message) use ($emails) {
				$message->to($emails);
				$message->subject('Invitation to Howlik');
				
			});
			/*var_dump( Mail:: failures());
		exit;*/
    }
}
