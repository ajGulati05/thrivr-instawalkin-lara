<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    

     public function scopeClientid($query)
    {
        return $query->where('client_id', 7);
    }
}
