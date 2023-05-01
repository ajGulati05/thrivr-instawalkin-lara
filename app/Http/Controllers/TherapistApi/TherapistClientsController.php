<?php

namespace App\Http\Controllers\TherapistApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Guest;
use App\Booking;
use App\Userprofile;
use App\Stripedata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TherapistApi\UserInformationResource; 
class TherapistClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //all bookings for a given therapist give me all users
        $guest=Guest::where('id',$id)->get();
        return response($guest);

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        Log::debug($request);
        $guest = Guest::find($id);
        $guest->first_name = request('first_name');
        $guest->last_name =request('last_name');
        $guest->email = request('email');
        $guest->phone = request('phone');
        $guest->save();
        return response($guest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

    }


    public function getListClients(Request $request){

       
         $manager=Auth::user();
          $bookingsByManager=Booking::select('bookable_id')->userType()->where('manager_id',$manager->id)->distinct()->get();
        //Booking::where('manager_id',$manager->id)->select('bookable_id','bookable_type')->distinct()->get();
        Log::debug(json_encode($bookingsByManager));
        

         $clients = collect();
                foreach ($bookingsByManager as $booking) {
                        $user=User::with('userprofiles','books')->where('id',$booking->bookable_id)->first();
                        $currentCustomerUser=new UserInformationResource($user,$manager);
                        $clients->push($currentCustomerUser);
                    }
         $paginatedClients=$clients->slice($request->_start)->take($request->_end-$request->_start);
         if(strtolower($request->_order=='asc')){
           $paginatedClientsSorted=$paginatedClients->sortBy($request->_sort)->values()->all();
         }
         else{
        $paginatedClientsSorted=$paginatedClients->sortByDesc($request->_sort)->values()->all();
         }
        return response($paginatedClientsSorted)
        ->header('x-total-count', $clients->count());
    }


    public function getListGuests(Request $request){

       
         $bookingsByManager=Auth::user()->bookings;
      
        

         $guests = collect();
                foreach ($bookingsByManager as $booking) {
                    if($booking->bookable_type==config('constants.configurations.bookable_type_guest'))
                    {
                    $currentCustomerUser['id'] = $booking->bookable_id;
                    $currentCustomerUser['has_credit_card'] = false;
                    $currentCustomerUser['email'] = $booking->bookable->email;
                    $currentCustomerUser['first_name'] = $booking->bookable->first_name;
                    $currentCustomerUser['last_name'] = $booking->bookable->last_name;
                     $currentCustomerUser['phone'] = $booking->bookable->phone;
                    $currentCustomerUser['user_type'] = config('constants.configurations.bookable_type_guest');
                 
                    $guests->push($currentCustomerUser);
                    }
    
                    
                }


          //  Log::debug($clients);
         $paginatedGuests=$guests->slice($request->_start)->take($request->_end-$request->_start);
         if(strtolower($request->_order=='asc')){
           $paginatedGuestsSorted=$paginatedGuests->sortBy($request->_sort)->values()->all();
         }
         else{
        $paginatedGuestsSorted=$paginatedGuests->sortByDesc($request->_sort)->values()->all();
         }
        return response($paginatedGuestsSorted)
        ->header('x-total-count', $guests->count());
    }

    public function getUserInformation($id){

        //get number of massages the user has gone for 
        $userInformation=User::find($id)->with('userprofiles')->get();
       //$userInformation= new UserInformationResource($user);
        return response($userInformation);

    }
}
