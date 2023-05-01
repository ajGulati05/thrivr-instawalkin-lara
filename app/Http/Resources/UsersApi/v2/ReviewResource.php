<?php

namespace App\Http\Resources\UsersApi\v2;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UsersApi\v2\ChildrenReviewResource;

class ReviewResource extends JsonResource
{

 
    public function toArray($request)
    {

   
   
        return [
           
       			'firstname'=>$this->reviewable->profiles->firstname,
       			'lastname'=>$this->reviewable->profiles->lastname,
       			'created_at'=>Carbon::parse($this->created_at,'UTC')->isoFormat('MMM Do, YYYY'),
       			'body'=>$this->comment,
       		//	'replies'=>ChildrenReviewResource::collection($this->replies->load('reviewable.profiles')),
       			'verified'=>$this->verified,
            'avatar'=>config('app.s3_bucket_address').$this->reviewable->profiles->avatar,
     
            ];
    }
}
