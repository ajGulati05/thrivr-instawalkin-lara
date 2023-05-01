<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerNotifications extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'desktop'=>$this->desktop,
            'desktopsound'=>$this->desktopsound,
            'web'=>$this->web,
            'websound'=>$this->websound,
            'alwaysonline'=>$this->alwaysonline,
            'switchtophone'=>$this->switchtophone
        ];
    }

      public function with($request)
    {
        return [
            'error'=>false];
    }
}
