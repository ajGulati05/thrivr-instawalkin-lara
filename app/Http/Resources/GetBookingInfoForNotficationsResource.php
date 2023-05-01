<?php

namespace App\Http\Resources;

use App\Booking;
use App\Guest;
use App\Manager;
use App\Project;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\PriceCalculationTrait;
class GetBookingInfoForNotficationsResource extends JsonResource
{
    use PriceCalculationTrait;
    public function __construct($booking_id, $user_id)
    {
        $this->user_id = $user_id;
        $this->booking_id = $booking_id;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Log::debug('REQUEST RESOURCE GET BOOKING INFO FOR NOTIFICATIONS RESOURCE------------------------------------');
        Log::debug($this->user_id);
        Log::debug($this->booking_id);

        $booking_id = $this->booking_id;
        $user_id = $this->user_id;

        $booking = Booking::find($booking_id);
        $manager = $booking->manager;
        $project = Project::with('activeprojectpricing.calculatetax')->where('id', $booking->project_id)->first();
        $project_pricing = $project->activeprojectpricing[0];
        $manager_speciality = $booking->managerSpeciality;
        $bookingPricing = $booking->activeBookingPricing->first();
        $activeBookingPricing=$this->SpitOutCorrectAmounts($bookingPricing);
        $managerObject = Manager::with('manager_profiles', 'activemanagerlicense')->where('id', $manager->id)->first();
        $massageTime =  Carbon::parse($booking->start, 'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');

        if ($booking->bookable_type == config('constants.configurations.bookable_type_user')) {
            Log::debug('BOOKABLE TYPE USER');
            $customer = User::find($booking->bookable_id);
            $customerProfile = $customer->userprofiles;
            $customerInfo['firstname'] = $customerProfile->firstname;
            $customerInfo['lastname'] = $customer->lastname;
        } else if ($booking->bookable_type == config('constants.configurations.bookable_type_guest')) {
            Log::debug('BOOKABLE TYPE GUEST');
            $customer = Guest::find($booking->bookable_id);
            Log::debug($customer);

            $customerInfo['firstname'] = $customer->first_name;
            $customerInfo['lastname'] = $customer->last_name;
        }
        if ($booking->paid_by == config('constants.configurations.payment_type_credit')) {
            Log::debug('CREDIT ');
            $amountToPay = $bookingPricing->credit_card_amount;
            $payment_method=config('constants.configurations.payment_type_credit_string');

        } else if ($booking->paid_by == config('constants.configurations.payment_type_cash')) {
            Log::debug('CASH ');
            $amountToPay = $bookingPricing->cash_amount;
            $payment_method=config('constants.configurations.payment_type_cash_string');
        }
        Log::debug('GETS HERE ');

        $activeLicense = $managerObject->activemanagerLicense[0];



        //get old booking info
        if ($request->old_booking_id != null) {
            Log::debug('RESCHEDULING');
            $oldBooking = Booking::find($request->old_booking_id);
            $oldBookingPricing = $oldBooking->activeBookingPricing->first();
            return [
                "customer_firstname" => $customerInfo['firstname'],
                "therapist_firstname" => $managerObject->first_name,
                "massage_time" => $massageTime,
                "cancellationFee" => $bookingPricing->amount,
                "address" => $managerObject->manager_profiles->address,
                "city" => $managerObject->manager_profiles->city,
                "amountToPay" => $amountToPay,
                "tipAmount" => $bookingPricing->tip_amount,
                "oldCancellationFee" => $oldBookingPricing->amount,
                "oldTipAmount" => $oldBookingPricing->tip_amount,
                "project_name" => $project->name,
                "manager_speciality_code" => $manager_speciality->description,
                "address_description"=>$managerObject->manager_profiles->address_description,
                 "discountAmount" => $bookingPricing->discount_amount,
            ];
        } else {
            return [
                "customer_firstname" => $customerInfo['firstname'],
                "therapist_firstname" => $managerObject->first_name,
                "massage_time" => $massageTime,
                "cancellationFee" => $bookingPricing->amount,
                "address" => $managerObject->manager_profiles->address,
                "city" => $managerObject->manager_profiles->city,
                "amountToPay" => $amountToPay,
                "tipAmount" => $bookingPricing->tip_amount,
                "project_name" => $project->name,
                "manager_speciality_code" => $manager_speciality->description,
                "customer_lastname" => $customerInfo['lastname'],
                "therapist_lastname" => $managerObject->last_name,
                'therapist_postal_code' => $managerObject->manager_profiles->postal_code,
                "therapist_phone" => $managerObject->manager_profiles->phone,
                "therapist_license_number" => $activeLicense->license_number,
                "project_pricing_amount" => $project_pricing->amount,
                "taxAmount" => $bookingPricing->tax_amount,
                "discountAmount" => $bookingPricing->discount_amount,
                "payment_method"=>$payment_method,
                "address_description"=>$managerObject->manager_profiles->address_description
            ];
        }
    }
}
