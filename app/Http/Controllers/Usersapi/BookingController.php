<?php

namespace App\Http\Controllers\Usersapi;

use App\Booking;
use App\BookingPricing;
use App\BookingTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Requests\CancelBookingTimekitRequest;
use App\Http\Resources\GetOpenSlotsByDateResource;
use App\Http\Traits\BookingTrait;
use App\Http\Traits\TimekitTrait;
use App\Http\Traits\StripeTrait;
use App\Manager;
use App\ManagerProfile;
use App\Project;
use App\Stripedata;
use App\User;
use Cartalyst\Stripe\Stripe;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersApiNew\StripeDataResources;
use App\Http\Resources\UsersApiNew\BookingResources;
use App\ProjectPricing;
use App\Taxes;
use Illuminate\Support\Facades\App;
//use App\Http\Traits\NotificationsTrait;
use Cartalyst\Stripe\Exception\MissingParameterException;
use Cartalyst\Stripe\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    use TimekitTrait;
    use BookingTrait;
    use StripeTrait;
    //use NotificationsTrait;

    public function __construct(){
        
    }


    public function book(Request $request)
    {
       
        //GATHERING THE PARAMS
        //First Step: create a timekit booking record
        $user_info=Auth::user()->load('userprofiles');
        $coupon_amount=0;
        $count_booking=Booking::where([['bookable_id', $user_info->id], ['bookable_type', 'App\User']])->count();
         if($count_booking>0){
            $coupon_amount=0;
         }


        $stripedatas_id = $request->stripedatas_id; //could be null if paid by cash
        $project_id = $request->project_id;
        $project = Project::with('activeprojectpricing.calculatetax')->where('id', $project_id)->first();
        $manager_speciality_id = $request->manager_speciality_id;
        $timekit_resource_id = $request->timekit_resource_id;
        $paid_by = $request->paid_by;
        Log::debug('TIMEKIT RESOURCE ID');
        Log::debug($timekit_resource_id);
        $manager = Manager::where('timekit_resource_id', $timekit_resource_id)->first();
        Log::debug('MANAGER');
        Log::debug($manager);
        $managerProfile = ManagerProfile::where('manager_id', $manager->id)->first();
        Log::debug('MANAGER PROFILE');
        Log::debug($managerProfile);
        //why do you need a manager profile?
        $graph = config('constants.configurations.booking_graph');
        $app_source = $request->app_source;
        $by_source = 'USERS';
        $bookable_type = config('constants.configurations.bookable_type_user');
 
 if (App::environment(['production'])) { //customer is the user
        Log::debug('not in prod');
        $customer_id = $user_info->id;
        $customer_name = $user_info->userprofiles->firstname.' ' .$user_info->userprofiles->lastname;
        $customer_email = $user_info->email;} // this must be change to owner or team@instawalkin.com
else{
            $customer_id = Auth::user()->id;
        $customer_name = config('constants.configurations.booking_customer_name');
        $customer_email = config('constants.configurations.booking_customer_email'); 
}
        $start = $request->start;
        $end = $request->end;
        $what = $project->name; //make query of the project title
        $where = ($managerProfile != null) ? $managerProfile->address : null;
        $description = $project->description;

        //CREATING REQUEST FOR TIMEKIT BOOKING
        $bookRequest = new BookRequest();
        $bookRequest->timekit_resource_id = $timekit_resource_id;
        $bookRequest->graph = $graph;
        $bookRequest->customer_id = $customer_id;
        $bookRequest->customer_name = $customer_name;
        $bookRequest->customer_email = $customer_email;
        $bookRequest->start = $start;
        $bookRequest->end = $end;
        $bookRequest->what = $what;
        $bookRequest->where = $where;
        $bookRequest->description = $description;
        $bookRequest->manager_id = $manager->id;
        $bookRequest->project_id = $project->id;
        $bookRequest->app_source = $app_source;
        $bookRequest->paid_by = $paid_by;
        $bookRequest->by_source = $by_source;
        $bookRequest->manager_speciality_id = $manager_speciality_id;
        $bookRequest->project_pricing_id = $project->activeprojectpricing[0]->id;

        Log::debug('PASSES REQUEST FORMATION');
        Log::debug(json_encode($bookRequest));

        $bookError = null;
        try {
            $responseBooking = $this->bookTimekit($bookRequest);
            $timekit_booking_id = $responseBooking['data']['id'];

            Log::debug('RESPONSE TIMEKIT BOOKING SAVING=====================================================');
            Log::debug($timekit_booking_id);

            //here we save the booking in the database
            $requestSaveBookdatabaseRequest = new Request();
            $requestSaveBookdatabaseRequest->timekit_resource_id = $timekit_resource_id;
            $requestSaveBookdatabaseRequest->graph = $graph;
            $requestSaveBookdatabaseRequest->bookable_id = $customer_id;
            $requestSaveBookdatabaseRequest->start = $start;
            $requestSaveBookdatabaseRequest->end = $end;
            $requestSaveBookdatabaseRequest->what = $what;
            $requestSaveBookdatabaseRequest->where = $where;
            $requestSaveBookdatabaseRequest->project_id = $project->id;
            $requestSaveBookdatabaseRequest->description = $description;
            $requestSaveBookdatabaseRequest->manager_id = $manager->id;
            $requestSaveBookdatabaseRequest->timekit_booking_id = $timekit_booking_id;
            $requestSaveBookdatabaseRequest->manager_speciality_id = $manager_speciality_id;
            $requestSaveBookdatabaseRequest->app_source = $app_source;
            $requestSaveBookdatabaseRequest->paid_by = $paid_by;
            $requestSaveBookdatabaseRequest->by_source = $by_source;
            $requestSaveBookdatabaseRequest->bookable_type = $bookable_type;
            $requestSaveBookdatabaseRequest->project_pricing_id = $project->activeprojectpricing[0]->id;
            $saveBooking = $this->saveBookingTrait($requestSaveBookdatabaseRequest);
            Log::debug('BOOK SAVED IN DATABASE');

            //CALCULATE AMOUNT TO CHARGE

            Log::debug('PROJECT PRICING');

            if ($project->activeprojectpricing[0] != null) {
                $project_pricing_amount = $project->activeprojectpricing[0]->amount;

                //GET TAXES VALUES
                $totalTaxes = $project->activeprojectpricing[0]->calculatetax->sum('taxpercent');

                if (is_null($totalTaxes) || $totalTaxes <= 0) {
                    $tax_amount = 0;

                    //CALCULATION OF TAX AMOUNT
                } else {
                    $tax_amount = ($totalTaxes / 100) * $project_pricing_amount;
                }

                switch ($request->paid_by) {
                    case config('constants.configurations.paid_by_cash'):
                        Log::debug('PAID IN CASH');
                        $requestSaveBookingPricing = new Request();
                        $requestSaveBookingPricing->booking_id = $saveBooking->id;
                        $requestSaveBookingPricing->tax_amount = $tax_amount;
                        $requestSaveBookingPricing->amount = $project_pricing_amount;
                        $requestSaveBookingPricing->credit_card_amount = null;
                        $requestSaveBookingPricing->cash_amount = $project_pricing_amount + $tax_amount;
                        if($coupon_amount>0){
                        $requestSaveBookingPricing->discount_amount = $coupon_amount;
                    }
                        $requestSaveBookingPricing->active = true;
                        $responseSaveBookingPricing = $this->saveBookingPricing($requestSaveBookingPricing);
                        break;
                    case config('constants.configurations.paid_by_credit'):
                        Log::debug('PAID IN CREDIT');

                        $requestSaveBookingPricing = new Request();
                        $requestSaveBookingPricing->booking_id = $saveBooking->id;
                        $requestSaveBookingPricing->tax_amount = $tax_amount;
                        $requestSaveBookingPricing->amount = $project_pricing_amount;
                        $requestSaveBookingPricing->credit_card_amount = $project_pricing_amount + $tax_amount;
                        $requestSaveBookingPricing->cash_amount = 0;
                        $requestSaveBookingPricing->active = true;
                           if($coupon_amount>0){
                       $requestSaveBookingPricing->discount_amount = $coupon_amount;
                   }
                        $responseSaveBookingPricing = $this->saveBookingPricing($requestSaveBookingPricing);

                        //STRIPE default CARD

                        Log::debug('DEFAULT CARD');
                        Log::debug($stripedatas_id);

                        //Booking transactions table
                        if ($paid_by != config('constants.configurations.paid_by_cash')) {
                            BookingTransaction::Create([
                                "booking_pricing_id" => $responseSaveBookingPricing->id,
                                "stripedatas_id" => $stripedatas_id,
                            ]);
                        } else {
                            Log::debug('NO DEFAULT CARD, UNLIKELY TO HAPPEN');
                        }
                        break;
                }
            }
         


            $allbookings = Booking::with('project', 'managerSpeciality', 'activeBookingPricing.active_booking_transactions', 'manager.manager_profiles')->where([['bookable_id',  $customer_id], ['bookable_type', 'App\User'], ['id', $saveBooking->id]])->get();
            return BookingResources::collection($allbookings)->keyBy('id');
        } catch (ClientException $exception) {
           
            return response()->json(['error' => true, 'message' => $bookError, 'code' => 401], 401);
        }
    }

    public function getOpenSlotsByDate(Request $request)
    {
        $getOpenSlotsByDateResource = new GetOpenSlotsByDateResource($request);
        return $getOpenSlotsByDateResource;
    }


    public function create_receipt(Request $request)
    {
        try {
            $booking_id = $request->booking_id;
            $requested_by = 'USER';

            $createReceiptRequest = new Request();
            $createReceiptRequest->booking_id = $booking_id;
            $createReceiptRequest->requested_by = $requested_by;
            $createReceiptRequest->requested_by_id = Auth::user()->id; //change this

            $responseCreateReceipt =  $this->create_receipt_trait($createReceiptRequest);
            Log::debug('RESPONSE CREATE RECEIPT');
            Log::debug($responseCreateReceipt);
            return response()->json(['error' => false, 'show' => true, 'title' => 'Success!', "message" => 'An email was sent to ' . Auth::user()->email . ' If you don\'t recieve your email soon, check your SPAM folder'], 200);
        } catch (ClientException $exception) {
            Log::debug('EXCEPTION');
            Log::debug($exception);
            return response()->json(['error' => true, 'show' => true, 'title' => 'Oops!', 'message' => 'There was an issue on our side, we are looking into it.'], 200);
        }
    }

    public function rescheduleBook(Request $request)
    {
        try {
            $responseBooking = $this->book($request);
            Log::debug('RESPONSE BOOKING=================================================');
            Log::debug($responseBooking->getContent());

            if ($responseBooking->getStatusCode() == 200) {
                $decodedBookingResponse = json_decode($responseBooking->getContent());
                // Log::debug($decodedBookingResponse);

                $rescheduleBookChargeRequest = new Request();
                $rescheduleBookChargeRequest->booking_id = $request->old_booking_id;
                $rescheduleBookChargeRequest->status_changed_by = config('constants.configurations.by_source_users');
                $rescheduleBookChargeRequest->percentage_to_deduct = Booking::RESCHEDULE_FEE_PERCENTAGE;
                $rescheduleBookChargeRequest->booking_status = config('constants.configurations.booking_status_rescheduling');
                $responseRescheduleCharge = $this->cancelOrRescheduleChargeBookTrait($rescheduleBookChargeRequest);
                Log::debug('RESPONSE OF CANCEL BOOK IN CONTROLLER');
                Log::debug($responseRescheduleCharge);

                //SENDING NOTIFICATION EMAIL TO THERAPIST
                $notificationRescheduleToTherapistRequest =  new Request();
                $dataNotificationToTherapist['old_booking_id'] = $request->old_booking_id;
                $dataNotificationToTherapist['booking_id'] = $decodedBookingResponse->id;
                $notificationRescheduleToTherapistRequest->data = $dataNotificationToTherapist;
                $notificationRescheduleToTherapistRequest->reason = config('constants.notifications.notification_booking_rescheduled');
                $this->sentNotificationToTherapist($notificationRescheduleToTherapistRequest);


                //SENDING NOTIFICATION EMAIL TO USER
                $notificationRescheduleToUserRequest =  new Request();
                $dataNotificationToUser['old_booking_id'] = $request->old_booking_id;
                $dataNotificationToUser['booking_id'] = $decodedBookingResponse->id;
                $notificationRescheduleToUserRequest->data = $dataNotificationToUser;
                $notificationRescheduleToUserRequest->reason = config('constants.notifications.notification_booking_rescheduled');
                $this->sentNotificationToUser($notificationRescheduleToUserRequest);


                //cancel in timekit 
                try {
                    $booking = Booking::find($request->old_booking_id);
                    //CANCEL BOOKING THERAPIST IN TIMEKIT
                    $timekit_booking_id = $booking->timekit_booking_id;
                    Log::debug('TIMEKIT BOOKING ID');
                    Log::debug($timekit_booking_id);
                    $cancelBookingTimekitRequest = new CancelBookingTimekitRequest();
                    $cancelBookingTimekitRequest->timekit_booking_id = $timekit_booking_id;
                    $responseCancelBookingTimekit =  $this->cancelBookingTimekit($cancelBookingTimekitRequest);
                    Log::debug('RESPONSE CANCEL TIMEKIT');
                    Log::debug($responseCancelBookingTimekit);

                    return response('cancellation successful', 200);
                } catch (Exception $e) {
                    Log::debug('EXCEPTION IN CANCEL BOOKING');
                    Log::debug($e);
                    return response("there was a problem with timekit", 401);
                }
            } else {
                return response("Timekit booking had a problem", 401);
            }
        } catch (ClientException $exception) {
            Log::debug('EXCEPTION');
            Log::debug($exception);
            return response("Cancellation Exception in TimekitTrait / cancelBookingTimekit", 401);
        }
    }

    public function cancelBook(Request $request)
    {
        try {
            $rescheduleBookChargeRequest = new Request();
            $rescheduleBookChargeRequest->booking_id = $request->booking_id;
            $rescheduleBookChargeRequest->status_changed_by = config('constants.configurations.by_source_users');
            $rescheduleBookChargeRequest->percentage_to_deduct = Booking::CANCEL_FEE_PERCENTAGE;
            $rescheduleBookChargeRequest->booking_status = config('constants.configurations.booking_status_cancellation');
            $response = $this->cancelOrRescheduleChargeBookTrait($rescheduleBookChargeRequest);
            Log::debug('RESPONSE OF CANCEL BOOK IN CONTROLLER');
            Log::debug($response);

            //maybe the messag can be controlled in the noticication
            // SENDING NOTIFICATION EMAIL TO THERAPIST
            $notificationRescheduleToTherapistRequest =  new Request();
            $dataNotificationToTherapist['booking_id'] = $request->booking_id;
            $notificationRescheduleToTherapistRequest->data = $dataNotificationToTherapist;
            $notificationRescheduleToTherapistRequest->reason = config('constants.notifications.notification_booking_cancelled');
            $this->sentNotificationToTherapist($notificationRescheduleToTherapistRequest);
            //FIX THIS 

            //SENDING NOTIFICATION EMAIL TO THERAPIST
            $notificationRescheduleToUserRequest =  new Request();
            $dataNotificationToUser['booking_id'] =  $request->booking_id;
            $notificationRescheduleToUserRequest->data = $dataNotificationToUser;
            $notificationRescheduleToUserRequest->reason = config('constants.notifications.notification_booking_cancelled');
            $this->sentNotificationToUser($notificationRescheduleToUserRequest);
            // }
            //FIX THIS 
        

            // cancel in timekit 
            try {
                $booking = Booking::find($request->booking_id);
                //CANCEL BOOKING THERAPIST IN TIMEKIT
                $timekit_booking_id = $booking->timekit_booking_id;
            
                $cancelBookingTimekitRequest = new CancelBookingTimekitRequest();
                $cancelBookingTimekitRequest->timekit_booking_id = $timekit_booking_id;
                  Log::debug('RESPONSE CANCEL TIMEKIT3');
                $responseCancelBookingTimekit =  $this->cancelBookingTimekit($cancelBookingTimekitRequest);
              
                Log::debug($responseCancelBookingTimekit);
                  Log::debug('RESPONSE CANCEL TIMEKIT2');
                   return response()->json(['error' => false, 'show' => true, 'title' => 'Success!', 'message' => 'Massage has been cancelled.'], 200);
                // DONT NEED A RESPONSE HERE
            } catch (Exception $e) {
                Log::debug('EXCEPTION IN CANCEL BOOKING');
                Log::debug($e);
                   Log::debug($responseCancelBookingTimekit);
                   return response()->json(['error' => false, 'show' => true, 'title' => 'Success!', 'message' => 'Massage has been cancelled.'], 200);
                //IF THIS HAPPENS SEND AN EMAIL TO ME
            }


        } catch (ClientException $exception) {
            Log::debug('EXCEPTION');
            Log::debug($exception);
            return response()->json(['error' => true, 'show' => true, 'title' => 'Oops!', 'message' => 'There was an issue on our side, we are looking into it. Please contact support@instawalkin.com'], 200);
        }
    }
    public function getAllBookings(Request $request)
    {
        
        $user = Auth::user();


   $userBooks=$user->load('books','books.manager.profiles','books.managerSpeciality','books.userGuests','books.activeBookingPricing','books.project');
  
        //will need to add with method
        //return $allbookings;

     
 
        return BookingResources::collection($userBooks->books)->keyBy('id');
    }

    public function postTip(Request $request)
    {

        Log::debug($request);
        $tip_amount = $request->tip_amount;
        $booking_id = $request->booking_id;
  
        $booking = Booking::where('id',$booking_id)->where('closed',false)->first();
     Log::debug($booking);
        //////how do you know this is active??????
        $booking_pricing = BookingPricing::where([['booking_id', $booking_id], ['active', true]])->first();
      
        $booking_pricing->credit_card_amount = floatval($booking_pricing->credit_card_amount) + floatval($tip_amount);
        $booking_pricing->tip_amount = floatval($tip_amount);
        $booking_pricing->save();

                  try {
                       
                            $this->_postCreditCharges($booking_pricing,$booking,true);
                           
                     
                            return response()->json(['error' => false, 'success' => false, 'code' => '200'], 200);
                        }

                catch (Exception $e){
                     return response()->json(['error' => false, 'success' => false, 'code' => '200'], 200);
                }
       
    }
    public function unsubscribe(Request $request)
    {
        Log::debug($request);
        return view('unsubscribe');
    }

   
}
