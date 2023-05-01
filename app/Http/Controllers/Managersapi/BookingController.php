<?php

namespace App\Http\Controllers\Managersapi;

use App\Booking;
use App\BookingTransaction;
use App\Guest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GetCustomersAndProjectsResource;
use App\Http\Traits\BookingTrait;
use App\Http\Traits\TimekitTrait;
use App\Manager;
use App\ManagerProfile;
use App\Notifications\SendReciepts;
use App\Project;
use App\Receipt;
use App\Transactions;
use App\User;
use App\Userprofile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\CommonResources\ProjectResource;
use App\ProjectPricing;
use App\Stripedata;
use App\Taxes;
use Exception;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    use TimekitTrait;
    use BookingTrait;


   public function getCustomersAndProjects(Request $request)
   {

        // $timekit_resource_id = 'dd23cbcf253735-414b-9664-3eade6cc7584';// $request->timekit_resource_id;
         $timekit_resource_id = $request->timekit_resource_id;
         $allbookings=Manager::with('bookings.bookable')->where('timekit_resource_id',$timekit_resource_id)->first();
        $projectList = collect();

        //$users = User::all();//here must be filtered
        $bookingsByManager = $allbookings->bookings;

        Log::debug('BOOKINGS BY MANAGER');
        Log::debug($bookingsByManager);
     
        $customerList = collect();

   
     
            //We get the projects
            $projectPricing = Project::with('project_pricings')->get();
            $projectList = ProjectResource::collection($projectPricing);// fucking idiot and a half
   
            //First we get the Users
            if (count($bookingsByManager) > 0) {

                $users = collect();
                foreach ($bookingsByManager as $booking) {
                    if($booking->bookable_type==config('constants.configurations.bookable_type_user'))
                    {
                        $currentCustomerUser['id'] = $booking->bookable->id;
                        $userprofile=Userprofile::where('user_id',$booking->bookable->id)->first();
                        $currentCustomerUser['email'] = $booking->bookable->email;
                        $currentCustomerUser['first_name'] = $userprofile->firstname;
                        $currentCustomerUser['last_name'] = $userprofile->lastname;
                        $currentCustomerUser['user_type'] = config('constants.configurations.bookable_type_user');
                        $currentCustomerUser['phone'] = $userprofile->phone;
                    $stripecount = Stripedata::where('user_id', $booking->bookable->id)->count();
                     if ($stripecount > 0) {
                        $currentCustomerUser['has_credit_card'] = true;
                    } else {
                        $currentCustomerUser['has_credit_card'] = false;
                    }
                    }
                    else// we assume its a guest

                    {
                    $currentCustomerUser['id'] = $booking->bookable->id;
                    $currentCustomerUser['has_credit_card'] = false;
                    $currentCustomerUser['email'] = $booking->bookable->email;
                    $currentCustomerUser['first_name'] = $booking->bookable->first_name;
                    $currentCustomerUser['last_name'] = $booking->bookable->last_name;
                    $currentCustomerUser['user_type'] = config('constants.configurations.bookable_type_guest');
                    

                    }
                    $customerList->push($currentCustomerUser);
                }
     
}

        

            $getCustomersAndProjectsRequest = new Request();
            $getCustomersAndProjectsRequest->projects = $projectList;
            $getCustomersAndProjectsRequest->customers = $customerList->unique()->values()->all();

            $getCustomersAndProjectsResource = new GetCustomersAndProjectsResource($getCustomersAndProjectsRequest);

            return response($getCustomersAndProjectsResource, 200);
    }

    public function saveNewUser(Request $request)
    {
        $first_name =  $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;

        Log::debug($email);
        Log::debug($first_name);
        Log::debug($last_name);


        $guest =  Guest::Create([
            "email" => $email,
            "first_name" => $first_name,
            "last_name" => $last_name
        ]);

        return response([
            "id" => $guest->id,
            "email" => $guest->email,
            "first_name" => $guest->first_name,
            "last_name" => $guest->last_name,
            "user_type" => config('constants.configurations.bookable_type_guest')
        ], 200);
    }

    public function saveBooking(Request $request)
    {
        try {
            //saving booking in database
            $responseSaveBooking = $this->saveBookingTrait($request);
            Log::debug('RESPONSE SAVE BOOKING');
            Log::debug($responseSaveBooking);

            //CALCULATE AMOUNT TO CHARGE
            $project = Project::with('activeprojectpricing.calculatetax')->where('id', $request->project_id)->first();
            Log::debug('PROJECT ');
            Log::debug($project);

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

                //REQUEST FOR SAVING BOOKING PRICING
                Log::debug('BOOKABLE TYPE');
                Log::debug($request->bookable_type);

                switch ($request->bookable_type) {
                    case config('constants.configurations.bookable_type_user'):
                        switch ($request->paid_by) {
                            case config('constants.configurations.paid_by_cash'):
                                Log::debug('PAID IN CASH');
                                $requestSaveBookingPricing = new Request();
                                $requestSaveBookingPricing->booking_id = $responseSaveBooking->id;
                                $requestSaveBookingPricing->tax_amount = $tax_amount;
                                $requestSaveBookingPricing->amount = $project_pricing_amount;
                                $requestSaveBookingPricing->credit_card_amount = null;
                                $requestSaveBookingPricing->cash_amount = $project_pricing_amount + $tax_amount;
                                $requestSaveBookingPricing->active = true;
                                $responseSaveBookingPricing = $this->saveBookingPricing($requestSaveBookingPricing);
                                break;
                            case config('constants.configurations.paid_by_credit'):
                                Log::debug('PAID IN CREDIT');

                                $requestSaveBookingPricing = new Request();
                                $requestSaveBookingPricing->booking_id = $responseSaveBooking->id;
                                $requestSaveBookingPricing->tax_amount = $tax_amount;
                                $requestSaveBookingPricing->amount = $project_pricing_amount;
                                $requestSaveBookingPricing->credit_card_amount = $project_pricing_amount + $tax_amount;
                                $requestSaveBookingPricing->cash_amount = 0;
                                $requestSaveBookingPricing->active = true;
                                $responseSaveBookingPricing = $this->saveBookingPricing($requestSaveBookingPricing);

                                //STRIPE default CARD
                                $stripeDatass = Stripedata::where('user_id', $request->bookable_id)
                                    ->where('default_card', true)->first();
                                Log::debug('DEFAULT CARD');
                                Log::debug($stripeDatass);


                                //Booking transactions table
                                if ($stripeDatass != null) {
                                    Log::debug('STRIPEDATA ID');
                                    Log::debug($stripeDatass->id);

                                    BookingTransaction::Create([
                                        "booking_pricing_id" => $responseSaveBookingPricing->id,
                                        "stripedatas_id" => $stripeDatass->id,
                                    ]);
                                } else {
                                    Log::debug('NO DEFAULT CARD, UNLIKELY TO HAPPEN');
                                }
                                break;
                        }
                        break;
                    case config('constants.configurations.bookable_type_guest'):
                        Log::debug('GUEST');

                        $requestSaveBookingPricing = new Request();
                        $requestSaveBookingPricing->booking_id = $responseSaveBooking->id;
                        $requestSaveBookingPricing->tax_amount = $tax_amount;
                        $requestSaveBookingPricing->amount = $project_pricing_amount;
                        $requestSaveBookingPricing->credit_card_amount = null;
                        $requestSaveBookingPricing->cash_amount = $project_pricing_amount + $tax_amount;
                        $requestSaveBookingPricing->active = true;
                        $responseSaveBookingPricing = $this->saveBookingPricing($requestSaveBookingPricing);

                        break;
                    default:
                        break;
                }

                //NOW HERE WE SEND THE NOTIFICATIONS
                Log::debug('BOOKING SAVED INFO');
                Log::debug($responseSaveBooking);
                //SENDING NOTIFICATION EMAIL TO THERAPIST
                $notificationRequest =  new Request();
                $dataNotification['booking_id'] = $responseSaveBooking->id;
                $notificationRequest->data = $dataNotification;
                $notificationRequest->reason = config('constants.notifications.notification_booking_success');
                $this->sentNotificationToTherapist($notificationRequest);


                //SENDING NOTIFICATION EMAIL TO USER
                $notificationRescheduleToUserRequest =  new Request();
                $dataNotificationToUser['booking_id'] = $responseSaveBooking->id;
                $notificationRescheduleToUserRequest->data = $dataNotificationToUser;
                $notificationRescheduleToUserRequest->reason = config('constants.notifications.notification_booking_success');
                $this->sentNotificationToUser($notificationRescheduleToUserRequest);
            }

            return response($responseSaveBooking, 200);
        } catch (Exception $exception) {
            Log::debug('EXCEPTION IN SAVE BOOKING MANAGERSAPI');
            Log::debug($exception);

            $exceptionNotificationRequest =  new Request();
            $dataNotificationToUser['user_id'] = Auth::user()->id; 
            $dataNotificationToUser['error'] = $exception->getMessage(); 
            $dataNotificationToUser['manager_id'] = $request->manager_id;
            $dataNotificationToUser['start'] = $request->start;  
            $dataNotificationToUser['bookable_type'] =$request->bookable_type;  
            $exceptionNotificationRequest->data = $dataNotificationToUser;
            $exceptionNotificationRequest->reason = config('constants.notifications.notification_booking_failure');
            $this->sentExceptionNotificationToSupport($exceptionNotificationRequest);
            return response('The booking failed in the database', 401);

        }
    }

    public function create_receipt(Request $request)
    {
        Log::debug('REQUEST RECEIPT');
        Log::debug($request);
        try {
            $requestCreateReceipt = new Request();
            $requestCreateReceipt->requested_by = $request->requested_by;
            $requestCreateReceipt->requested_by_id = $request->requested_by_id;

            //get the booking id
            $booking = Booking::where('timekit_booking_id', $request->booking_id)->first();
            $requestCreateReceipt->booking_id = $booking->id;

            $responseCreateReceipt =  $this->create_receipt_trait($requestCreateReceipt);
            Log::debug('RESPONSE CREATE RECEIPT');
           
            return response($responseCreateReceipt, 200);
        } catch (ClientException $exception) {
            Log::debug('EXCEPTION');
            Log::debug($exception);
            return response('The booking failed in the database', 401);
        }
    }

    public function getBookingPricingsByBookingId(Request $request)
    {
        try {
            $responseGetBookingPricingsByBookingId =  $this->getBookingPricingsByBookingIdTrait($request);
            Log::debug('RESPONSE GET BOOKING PRICINTS BY BOOKING ID');
            Log::debug(json_encode($responseGetBookingPricingsByBookingId));

            return response(json_encode($responseGetBookingPricingsByBookingId), 200);
        } catch (ClientException $exception) {
            Log::debug('EXCEPTION');
            Log::debug($exception);
            return response('GetBookingPricingsByBookingId failed', 401);
        }
    }
}
