<?php

namespace App\Larapen\Listeners;

use App\Larapen\Events\SendMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Larapen\Models\User;
use Illuminate\Support\Facades\Mail;
use Auth;

class SendMailFired
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
     * @param  SendMessage  $event
     * @return void
     */
    public function handle(SendMessage $event)
    {
		//echo '<pre>';print_r($event);die;
		$user12 = '';
			if($event!=''){
				$userFromA = User::find($event->user_from)->toArray();
				$userFrom = 'User';
				if(isset($userFromA['name']) && trim($userFromA['name'])!=''){
					$userFrom = trim($userFromA['name']);
				}
				$user12 = User::find($event->cust_Id)->toArray();
			
			//echo "<pre>";print_r($user12);die;
			
			if($event->subject != "")
			{
				$testAr = array('subject' => $event->subject);
				Mail::send('emails.friends.message', ['user12' => $user12,'userFrom' => $userFrom,'mess' => $event->message,'sub' => $event->subject], function($message) use ($user12, $testAr) {
					$message->to($user12['email']);
					$message->subject($testAr['subject']);
					
				});
				 return ['status' => 'success'];
			}
			else
			{
				$s = \DB::table('friends_messages')
							->select('friends_messages.*','friends_messages.to_id as to_message','conversation.*',
													'conversation.id as conversation_id')
							->join('conversation','conversation.id','=','friends_messages.parent_id')
							->where('friends_messages.to_id',Auth::user()->id)
							->first();
				if($s->reply == 1)
				{
					$abc  = \DB::table('friends_messages')->select('id','subject')->where('parent_id',$s->conversation_id)->first();
					$testAr = array('subject' => $abc->subject);
					Mail::send('emails.friends.message', ['user12' => $user12,'userFrom' => $userFrom,'mess_id' => $s->id ,'mess' => $event->message,'sub' => $abc->subject], function($message) use ($user12, $testAr) {
						$message->to($user12['email']);
						$message->subject('RE : ' . $testAr['subject']);
						
					});
					 return ['status' => 'success'];
				} 
			}
		}
    }

}

