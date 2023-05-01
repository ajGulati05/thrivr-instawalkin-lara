<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use App\ContactForm;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\SlackMessage;
class ContactUsReply extends Notification
{

    protected $contactForm;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ContactForm $contactForm)
    {
        $this->contactForm=$contactForm;
        //
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



    public function toMail($notifiable)
    {


        
     return (new MailMessage)
        ->identifier(config('postmark.templates.contact_received_template'))
        ->include([
            'contactee_name' => $this->contactForm->name,
            

        ]);
    }



    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
public function toSlack($notifiable)
    {
     //   $timeForDemo=Carbon::parse($this->demoRequest->demo_date)->isoFormat('MMM Do, h:mm a');
     return (new SlackMessage)
                ->content("{$this->contactForm->name} has contacted you because {$this->contactForm->comment} phone {$this->contactForm->phone}  - There email {$this->contactForm->email}");
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
/*  return (new MailMessage)
                    ->subject('Instawalkin Customer Service')
                    ->greeting('Hello ' .$this->contactForm->name)
                    ->line('Thanks for contacting instawalkin.')
                    ->line("We’ve received your email and one of our representatives will contact you shortly on the number or email provided.")
                    ->line('In the mean time please check out our faq section.')
                    ->action('FAQ',url('/faq'))
                    ->line('Thank you,')
                    ->salutation('The instawalkin team');*/