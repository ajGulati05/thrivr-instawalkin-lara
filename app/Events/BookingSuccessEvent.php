<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class BookingSuccessEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::debug('EVENT BOOKING CONSTRUCTORS');
        //  Log::debug(json_encode($this));
        // Log::debug($request);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()

    {
        Log::debug('EVENT BOOKING BROADCASTON');
        //  Log::debug($this->request);
        return new PrivateChannel('timekit_booking');
    }
}
