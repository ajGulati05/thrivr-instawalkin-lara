<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;

class TherapistNotificationsResource extends JsonResource
{

 
    public function toArray($request)
    {

   
   
        return [
           
       			'booking_texts'=>$this->booking_texts,
       			'booking_emails'=>$this->booking_emails,
       			'review_emails'=>$this->review_emails,
       			
       	
            ];
    }
}
