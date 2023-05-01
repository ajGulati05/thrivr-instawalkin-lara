<?php

namespace App\Listeners;

use App\Events\ContactFormSubmit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs; 
use App\ContactForm;
class SendAcknowledgeContactEmail
{
    public $contactForm;

    public $connection = 'sqs';

   
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
     * @param  ContactFormSubmit  $event
     * @return void
     */
    public function handle(ContactFormSubmit $event)
    {
          $onConnection=config('queue.default');
         $onQueue= config('queue.sqs.queue');
        $contactForm=$event->contactForm;
        $message = (new ContactUs($contactForm))
                ->onConnection($onConnection)
                ->onQueue($onQueue);


        Mail::to($contactForm->email)->queue($message);
    }
}
