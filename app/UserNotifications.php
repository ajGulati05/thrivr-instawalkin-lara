<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NotificationChannels\Twilio\TwilioChannel;

class UserNotifications extends Model
{
    //

    protected $guarded = [];

    protected $casts = [
        'text_reminder' => 'boolean',
        'email_reminder' => 'boolean',
        'email_receipt' => 'boolean',
        'email_confirmation' => 'boolean',
        'product_update' => 'boolean',
        'future_reminder' => 'boolean',

    ];


    public function getFutureReminderAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }
    public function setFutureReminderAttribute($value)
    {

        if ($value == true) {
            $this->attributes['future_reminder'] = 1;
        } else {
            $this->attributes['future_reminder'] = 0;
        }

    }
    public function getProductUpdateAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }
    public function setProductUpdateAttribute($value)
    {

        if ($value == true) {
            $this->attributes['product_update'] = 1;
        } else {
            $this->attributes['product_update'] = 0;
        }

    }
    public function getTextReminderAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }

    public function getEmailReminderAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }

    public function getEmailReceiptAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }

    public function getEmailConfirmationAttribute($value)
    {


        if ($value == 1) {
            return true;
        } else {
            return false;
        }


    }

    public function setEmailReceiptAttribute($value)
    {
        if ($value == true) {
            $this->attributes['email_receipt'] = 1;
        } else {
            $this->attributes['email_receipt'] = 0;
        }
    }

    public function setEmailConfirmationAttribute($value)
    {
        if ($value == true) {
            $this->attributes['email_confirmation'] = 1;
        } else {
            $this->attributes['email_confirmation'] = 0;
        }
    }

    public function setEmailReminderAttribute($value)
    {
        if ($value == true) {
            $this->attributes['email_reminder'] = 1;
        } else {
            $this->attributes['email_reminder'] = 0;
        }
    }

    public function setTextReminderAttribute($value)
    {
        if ($value == true) {
            $this->attributes['text_reminder'] = 1;
        } else {
            $this->attributes['text_reminder'] = 0;
        }
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function emailReminderNotifications()
    {

        $notifiableVia = [];
        if ($this->text_reminder) {
            array_push($notifiableVia, TwilioChannel::class);
        }

        if ($this->email_reminder) {
            array_push($notifiableVia, "mail");
        }


        return $notifiableVia;

    }

    public function emailConfirmations()
    {
        $notifiableVia = [];

        if ($this->email_confirmation) {
            array_push($notifiableVia, "mail");
        }


        return $notifiableVia;
    }
    public function emailProductUpdate()
    {
        $notifiableVia = [];

        if ($this->product_update) {
            array_push($notifiableVia, "mail");
        }


        return $notifiableVia;
    }
    public function emailFutureReminder()
    {
        $notifiableVia = [];

        if ($this->future_reminder) {
            array_push($notifiableVia, "mail");
        }


        return $notifiableVia;
    }

    public function emailReceipt()
    {
        $notifiableVia = [];


        if ($this->emailReceipt) {
            array_push($notifiableVia, "mail");
        }


        return $notifiableVia;
    }

}
