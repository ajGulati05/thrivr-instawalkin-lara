<?php

namespace App\Vendor_override;


use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use App\Vendor_override\CoconutPackage\CustomCoconutMailMessage as MailMessage;
use Carbon\Carbon;
class CustomResetPasswordEmail extends ResetPassword
{

protected $actionUrl;
protected $name;

public function __construct( $actionUrl, $name) {
        $this->actionUrl = $actionUrl;
        $this->name=$name;
}

    public function toMail($notifiable)
    {


        
     return (new MailMessage)
        ->identifier(config('postmark.templates.password_reset_template'))
        ->include([
            'name' => $this->name,
            'action_url' => $this->actionUrl,
            'support_url'=>config('postmark.static_variables.support_url'),
            'date_text'=>Carbon::now()->isoFormat('MMM Do, h:mm'),
        ]);
    }
}