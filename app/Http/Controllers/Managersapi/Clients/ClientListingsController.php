<?php

namespace App\Http\Controllers\Managersapi\Clients;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Booking;
use App\Http\Resources\TherapistApi\v2\TherapistClientResource;
use App\Http\Resources\TherapistApi\v2\TherapistGuestResource;
use App\Http\Resources\TherapistApi\v2\TherapistClientGuestResource;
use App\User;
use App\Guest;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use App\Queries\Filters\FuzzyFilter;
class ClientListingsController extends Controller
{


    public function list(Request $request){

          $page=30;
      
         
          $manager=Auth::user();
          $users=$manager->clients()->pluck('user_id');
          $guests=$manager->guestsNotUser->pluck('id');//->getQuery();//->getQuery();
         


         $builtGuestQuery=QueryBuilder::for(Guest::whereIn('id',$guests))
          ->allowedFilters([AllowedFilter::custom('q',new FuzzyFilter('firstname','lastname','email')),AllowedFilter::custom('firstname',new FuzzyFilter('firstname')),
            AllowedFilter::custom('lastname',new FuzzyFilter('firstname')),
          AllowedFilter::custom('email',new FuzzyFilter('email'))])
          ->get();



       $builtQuery=QueryBuilder::for(User::whereIn('id',$users))
       ->allowedFilters([AllowedFilter::custom('q',new FuzzyFilter('profiles.firstname','profiles.lastname','email')),AllowedFilter::custom('firstname',new FuzzyFilter('profiles.firstname')),
        AllowedFilter::custom('lastname',new FuzzyFilter('profiles.lastname')),AllowedFilter::custom('email',new FuzzyFilter('email'))])
       ->get();

      
//no

$userResource=TherapistClientResource::collection($builtQuery);
$guestResource=TherapistGuestResource::collection($builtGuestQuery);


$patientResource= $userResource->merge($guestResource);
$patientSortByResource=$patientResource->sortBy('lastname');

$paginatedResource=(collect($patientSortByResource))->paginate($page);
        return response()->json(["status"=>true,'patients'=>$paginatedResource]);
   
      
     
     
    }   

  
public function detail(Request $request){
if(Request::exists('user')&&Request::has('user'))
{

 $manager=Auth::user();
 $user=$manager->clients()->where('user_id',request('user')->id)->first();

   $resourceToReturn=new TherapistClientResource($user);

}

if(Request::exists('guest')&&Request::has('guest'))
{
        if(request('guest')->user)
     {
           $resourceToReturn=new TherapistClientResource(request('guest')->user);
}
else{
     $resourceToReturn=new TherapistGuestResource(request('guest'));

 }
   

}

if(Request::exists('userGuest')&&Request::has('userGuest'))
{
    $resourceToReturn=new TherapistClientGuestResource(request('userGuest'));
    
 
}

   return response()->json(["data"=>$resourceToReturn,"status"=>true]);
   
}






}
