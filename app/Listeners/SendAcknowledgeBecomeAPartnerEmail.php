<?php

namespace App\Listeners;

use App\Events\BecomeAPartnerFormSubmit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\BecomeAPartner;
use App\PartnerForm;

class SendAcknowledgeBecomeAPartnerEmail implements ShouldQueue
{


    public $partnerForm;
   

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
     * @param  BecomeAPartnerFormSubmit  $event
     * @return void
     */
    public function handle(BecomeAPartnerFormSubmit $event)
    {

        $onConnection = config('queue.default');
        $onQueue = config('queue.sqs.queue');
        $partnerForm = $event->partnerForm;
        $message = (new BecomeAPartner($partnerForm))
            ->onConnection($onConnection)
            ->onQueue($onQueue);


        Mail::to($partnerForm->contactemail)->queue($message);
    }
}
