<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use App\DemoRequest;
use Illuminate\Notifications\Messages\SlackMessage;
use Carbon\Carbon;
class RequestDemoNotification extends Notification
{

protected $demoRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DemoRequest $demoRequest)
    {
            $this->demoRequest=$demoRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
public function toSlack($notifiable)
    {
        $timeForDemo=Carbon::parse($this->demoRequest->demo_date)->isoFormat('MMM Do, h:mm a');
     return (new SlackMessage)
                ->content("{$this->demoRequest->name} has requested a demo at {$timeForDemo} with {$this->demoRequest->timekit_resource_id}  - There email {$this->demoRequest->email}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
