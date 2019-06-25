<?php

namespace App\Larapen\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessage extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cust_id,$sub,$mess,$user_from='')   
    {
	  // echo '<pre>';print_r($cust_id.'_'.$sub.'_'.$mess.'_'.$user_from);die;
	   $this->user_from = $user_from;
	   $this->cust_Id = $cust_id;
	   $this->subject = $sub;
	   $this->message = $mess;
	  	 //  echo $this->cust_Id;die;
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
