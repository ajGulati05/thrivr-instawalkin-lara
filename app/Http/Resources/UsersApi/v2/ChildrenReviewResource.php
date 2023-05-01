<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Manager;
use Illuminate\Support\Facades\Log;
class ChildrenReviewResource extends JsonResource
{

 
    public function toArray($request)
    {

    

        return [
           
            'firstname'=>$firstname,
            'lastname'=>'',
       			'created_at'=>Carbon::parse($this->created_at,'UTC')->isoFormat('MMM Do, YYYY'),
       			'body'=>$this->comment
       			
       			
            ];
    }
}
