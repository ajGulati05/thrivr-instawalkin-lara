<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;

class UsernotificationResource extends JsonResource
{

 
    public function toArray($request)
    {

   
   
        return [
           
       			'text_reminder'=>$this->text_reminder,
       			'email_reminder'=>$this->email_reminder,
       			'email_receipt'=>$this->email_receipt,
       			'email_confirmation'=>$this->email_confirmation,
                'product_update' => $this->product_update
       	
            ];
    }
}
