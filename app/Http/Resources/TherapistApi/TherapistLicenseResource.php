<?php

namespace App\Http\Resources\TherapistApi;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class TherapistLicenseResource extends JsonResource
{

 

 
    public function toArray($request)
    {

   
   
        return [
           
       			'license_number'=>$this->license_number,
            'expired_at'=>$this->expired_at==null?null:Carbon::parse($this->expired_at, 'UTC')->setTimezone(Auth::user()->timezone)->isoFormat('MMM Do YYYY'),
       	 ];
    }
}
