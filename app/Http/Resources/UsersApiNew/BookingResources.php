<?php

namespace App\Http\Resources\UsersApiNew;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class BookingResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {



        return [
        "id"=>$this->id,
        
        "utc_start_date"=>Carbon::parse($this->start,'UTC'),
        "utc_end_date"=>Carbon::parse($this->end,'UTC'),
        "booking_status"=>$this->booking_status, // can be CANCELLED, RESECHDULED OR 
        
        "massage_description"=>'Please use Thrivr.ca',
        "massage_time"=>Carbon::parse($this->start,'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a'),
        "location_address"=>$this->manager->profiles->address,
        "address_description"=>$this->manager->profiles->address_description,
        "parking_description"=>$this->manager->profiles->parking_description,
        "person_name"=>$this->manager->first_name.' '.$this->manager->last_name,
        "lat"=>$this->manager->profiles->latitude,
        "lng"=>$this->manager->profiles->longitude,
        "city"=>$this->manager->profiles->city,
        "province"=>$this->manager->profiles->province,
        //
        "paid_by"=>$this->paid_by,//use to see what it was used to paid 
       //"stripe_brand"=>optional($this->activeBookingPricing[0]->active_booking_transactions[0]->stripedatasWithTrashed->)card_brand,
        //'stripe_last_4'=>optional($this->activeBookingPricing[0]->active_booking_transactions[0])->stripedatasWithTrashed->card_last_four, // this will be used to build a stripe label based on what was used to pay
        "closed"=>$this->closed,   //will be used to tell if its closed or we can still add tip etc
        "tax_percent"=>'5',
        "total_amount"=>100,
        "price"=>0,
        "tax_amount"=>0,
        "taxlabel"=>'GST 5%',
        "coupon_amount"=>0,
        "credit_card_amount"=>0,
        "cash_amount"=>0,
        "tip_amount"=>0
         ];
    }
}
/* "address": "1203 Herold Terrace",
                "phone": "+1 (306) 262-5152",
                "city": "Saskatoon",
                "province": "Saskatchewan",
                "postal_code": "S7V 1J7",
                "latitude": "52.1017",
                "longitude": "-106.568",
/*[
    {
        "id": 11,
        "manager_id": 31,
        "project_id": 3,
        "when": "2019-09-28 23:19:34",
        "start": "2019-09-29 16:15:00",
        "end": "2019-09-29 17:15:00",
        "timekit_booking_id": "99d7b84b-274c-47d7-84e1-71122b66e907",
        "bookable_id": 46,
        "bookable_type": "App\\User",
        "date_to_authorize": null,
        "paid_by": "CR",
        "direct_billing": 0,
        "closed": 0,
        "tip_paid_separately": 0,
        "booking_status": null,
        "status_changed_by": null,
        "app_source": "USER_MOBILE",
        "by_source": "USERS",
        "project_pricing_id": 6,
        "created_at": "2019-09-28 23:19:34",
        "updated_at": "2019-09-28 23:19:34",
        "manager_speciality_id": 1,
        "reason": null,
        "status_changed_date": null,
        "status_initiated_by": null,
        "status_initiated_on": null,
        "project": {
            "id": 3,
            "description": "test",
            "timekit_project_id": "f9b3712c-f52f-44ea-855f-bfd84d07df12",
            "slug": "test",
            "name": "TestProject",
            "created_at": "2019-09-14 04:10:01",
            "updated_at": "2019-09-27 05:44:20",
            "deleted_at": null,
            "length": "60 minutes",
            "buffer": "15 minutes",
            "default": false,
            "mobile_name": "TEST"
        },
        "manager_speciality": {
            "id": 1,
            "code": "RT",
            "description": "RELAXATION",
            "deleted_at": null,
            "created_at": null,
            "updated_at": null,
            "speciality_photo": null,
            "default": true
        },
        "active_booking_pricing": [
            {
                "id": 3,
                "booking_id": 11,
                "amount": "100.00",
                "tax_amount": "7.00",
                "created_at": "2019-09-28 23:19:34",
                "updated_at": "2019-09-28 23:19:34",
                "tip_amount": null,
                "credit_card_amount": "107.00",
                "discount_amount": null,
                "cash_amount": "0.00",
                "direct_billing_amount": null,
                "active": true,
                "active_booking_transactions": [
                    {
                        "id": 2,
                        "booking_pricing_id": 3,
                        "charge_id": null,
                        "capture_charge_id": null,
                        "stripe_code_status_charge": null,
                        "stripe_reason_charge": null,
                        "stripe_code_status_authorize": null,
                        "stripe_reason_authorize": null,
                        "stripedatas_id": 61,
                        "active": true,
                        "created_at": "2019-09-28 23:19:34",
                        "updated_at": "2019-09-28 23:19:34",
                        "stripedatas": {
                            "id": 61,
                            "stripe_id": "cus_FsDZGynPvJmbAv",
                            "card_brand": "Visa",
                            "card_last_four": "4242",
                            "card_token": null,
                            "default_card": 0,
                            "native_pay": false
                        }
                    }
                ]
            }
        ],
        "manager": {
            "id": 31,
            "email": "thiry@test.com",
            "online": 0,
            "lastpasswordchange_date": null,
            "emailsent": "NO",
            "emailconfirmed": "NO",
            "status": "ACTIVE",
            "statusreason": null,
            "created_at": "2019-09-14 04:08:52",
            "updated_at": "2019-09-14 20:07:57",
            "deleted_at": null,
            "timekit_resource_id": "dd23cbcf-3735-414b-9664-3eade6cc7584",
            "first_name": "pro",
            "last_name": "thirty",
            "gender": "F",
            "profile_photo": null,
            "manager_profiles": {
                "id": 1,
                "manager_id": 31,
                "address": "1203 Herold Terrace",
                "phone": "+1 (306) 262-5152",
                "city": "Saskatoon",
                "province": "Saskatchewan",
                "postal_code": "S7V 1J7",
                "latitude": "52.1017",
                "longitude": "-106.568",
                "code": "b",
                "created_at": "2019-09-14 20:01:04",
                "updated_at": "2019-09-27 05:45:48",
                "deleted_at": null,
                "tag_line": "test",
                "parking": true
            }
        }
    }
]
