<?php

namespace App\Http\Traits\v2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


trait FormFlowTrait
{
    
      /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function createEmailFormFlowURL(Model $booking)
    {
        

      
      //TODO add User:, Guest: Client
        $url= URL::temporarySignedRoute(
            "form.workflow",
          Carbon::parse($booking->start),
            [
                
                'param'=>$booking->timekit_booking_id
            ],
            false
        );

        return config('constants.urls.webapp').$url;
    }



}
