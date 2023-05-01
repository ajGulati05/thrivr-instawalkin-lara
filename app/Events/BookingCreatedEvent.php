<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Resources\TherapistApi\BookingAdapterResource;
class BookingCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  public $booking;
    public $eventType;
  public function __construct($booking,$eventType)
  {
      $this->booking = $booking;
      $this->eventType=$eventType;
  }

  public function broadcastOn()
  {
      //return ['my-channel'];
      $channelName='App.Manager.'.$this->booking->manager_id.'.bookings';
      return new PrivateChannel($channelName);
  }

  public function broadcastAs()
  {
      return 'App\Events\my-event';
  }

/**
 * Get the data to broadcast.
 *
 * @return array
 */
public function broadcastWith()
{
    return ['booking' => new BookingAdapterResource($this->booking),'eventType'=>$this->eventType];
}

}
