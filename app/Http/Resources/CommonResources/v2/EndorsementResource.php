<?php

namespace App\Http\Resources\CommonResources\v2;

use Illuminate\Http\Resources\Json\JsonResource;


class EndorsementResource extends JsonResource
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
            'id'=>$this->id,
            'name' => $this->name,
            'description'=>$this->description,
            'path'=>config('app.s3_bucket_address').$this->path
           
        ];
    }
}
