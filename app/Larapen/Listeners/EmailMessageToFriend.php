<?php

namespace App\Larapen\Listeners;

use App\Larapen\Events\SendMessageToFriend;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Larapen\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailMessageToFriend
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
     * @param  SendMessageToFriend  $event
     * @return void
     */
    public function handle(SendMessageToFriend $event)
    {
        $user123 	= User::find($event->cust_Id)
						->select('users.*','add_friend.*','users.id as userId')
						->join('add_friend','add_friend.friend_id','=','users.id')
						->first()
						->toArray();
		
		
		$abc = unserialize($user123['email_notifications']);
		//echo "<pre>";print_r($user123);  
		if($abc['receive_emails'] == 1)
		{
			 Mail::send('emails.friends.sendMessage', ['user123' => $user123], function($message) use ($user123) {
				$message->to($user123['email']);
				$message->subject('Event Testing');
			});
		}
       
    }
}
