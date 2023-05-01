<?php

namespace App\Notifications;

use App\Guest;
use App\Manager;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BookingErrorToUserNotification extends Notification
{
    use Queueable;
    protected $exceptionRequest;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $request)
    {
        $this->exceptionRequest = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $fromEmail = config('mail.fromTeam');
        Log::debug('EXCEPTION REQUEST NOTIFICAITON ');
        Log::debug(json_encode($this->exceptionRequest[0]));
        $request = $this->exceptionRequest[0];
        $manager_id = $request['manager_id'];
        $user_id = $request['user_id'];
        //$start = $request['start'];
        //$error = $request['error'];
        $bookable_type = $request['bookable_type'];

        $managerObject = Manager::with('manager_profiles', 'activemanagerlicense')->where('id', $manager_id)->first();
        $massageTime =  Carbon::parse($start, 'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');

        if ($bookable_type != null) {
            if ($bookable_type == config('constants.configurations.bookable_type_user')) {
                Log::debug('BOOKABLE TYPE USER');
                $customer = User::find($user_id);
                $customerProfile = $customer->userprofiles;
                $customerInfo['firstname'] = $customerProfile->firstname;
                $customerInfo['email'] = $customer->email;
            } else if ($bookable_type == config('constants.configurations.bookable_type_guest')) {
                Log::debug('BOOKABLE TYPE GUEST');
                $customer = Guest::find($user_id);
                Log::debug($customer);
                $customerInfo['firstname'] = $customer->first_name;
                $customerInfo['email'] = $customer->email;
            }
        }

        Log::debug('MANAGER');
        Log::debug(json_encode($managerObject));
        Log::debug('MANAGER OBJECT');
        Log::debug($managerObject);
        Log::debug('CUSTOMER INFO');
        Log::debug($customerInfo);

        return (new MailMessage)
            ->from($fromEmail['address'], $fromEmail['name'])
            ->subject('Booking Failure')
            ->greeting('Exception Message!')
            ->line("Sorry but there is an issue. Instawalkin is looking at this issue and the team will be in contact with your shortly")
            ->line("MANAGER DETAILS: ")
            ->line("id: " . $manager_id)
            ->line("email: " . $managerObject->email)
            ->line("USER DETAILS: ")
            ->line("id: " . $user_id)
            ->line("email: " . $customerInfo['email'])
            ->line("BOOKING DETAILS: ")
            ->line("ERROR: ")
            ->line($error);

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
