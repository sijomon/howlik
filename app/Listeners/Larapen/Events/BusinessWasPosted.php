<?php

namespace App\Larapen\Events;

use App\Events\Event;
use App\Larapen\Models\Business;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BusinessWasPosted extends Event
{
    use SerializesModels;
    
    public $business;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
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
