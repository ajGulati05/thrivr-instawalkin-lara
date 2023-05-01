<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersSessionResource extends JsonResource
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
            "access_token" => $this->access_token,
            "refresh_token" => $this->refresh_token,
            "expires_in"=>$this->expires_in,
            "token_type"=>$this->token_type,
        ];
    }
}
