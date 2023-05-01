<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationSentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   public function toArray($request)
    {
        return [
            "id"=>$this->id,
            'notification_id'=>$this->notification_id,
            'notification_data'=>$this->notification_data,
            'read'=>$this->read,
          
     ];
    }
}
