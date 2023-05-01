<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PartnerForm;
class BecomeAPartner extends Mailable
{
    use Queueable, SerializesModels;
 public $partnerForm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PartnerForm $partnerForm)
    {
        //
        $this->partnerForm=$partnerForm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   

         return $this->view('emails.forms.becomeapartneracknowledge');
    }
}
