<?php

namespace App\Http\Resources\UsersApi;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use JWTAuth;
use JWTAuthException;
class PromocodehistoryResource extends JsonResource
{

 
    public function toArray($request)
    {

     $token = JWTAuth::getToken();
     $user = JWTAuth::toUser($token); 

   
        return [
            "code"=>$this->code,
            "expires_at"=>Carbon::parse($this->expires_at)->toFormattedDateString(),
            "data"=>$this->data,
            "reward"=>$this->reward,
            "id"=>$this->id,
            "count"=>$user->promocodehistory->promocodeusedcount(['promocode_id'=>$this->id])->promocodeusercount(['user_id'=>$user->id])->count(),
            "old"=>$this->expires_at->gt(Carbon::now())?1:0,
            "closestoexpiry"=>$this->expires_at->diff(Carbon::now()),
            "usesleft"=> $this->data['spread']- $user->promocodehistory->promocodeusedcount(['promocode_id'=>$this->id])->promocodeusercount(['user_id'=>$user->id])->count(),
            "actualrewardamount"=>$this->reward/$this->data['spread']
           //"left"=>($user->promocodehistory->promocodeusedcount(['promocode_id'=>$this->id])*($this->reward/$this->data["spread"]))

            ];
    }
}
