<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Postmark credentials
    |--------------------------------------------------------------------------
    |
    | Here you may provide your Postmark server API token.
    |
    */

    'secret' => env('POSTMARK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Guzzle options
    |--------------------------------------------------------------------------
    |
    | Under the hood we use Guzzle to make API calls to Postmark.
    | Here you may provide any request options for Guzzle.
    |
    */

    'guzzle' => [
        'timeout' => 10,
        'connect_timeout' => 10,
    ],

    'templates'=>[
        'password_reset_template'=>env('POSTMARK_PASSWORD_RESET_TEMPLATE'),
        'contact_received_template'=>env('POSTMARK_CONTACT_RECEIVED_TEMPLATE'),
        'verification_template'=>env('POSTMARK_VERIFICATION_TEMPLATE'),
         'receipt_template'=>env('POSTMARK_RECEIPT_TEMPLATE'),
         'manager_booking_template'=>env('POSTMARK_MANAGER_BOOKING_TEMPLATE'),
         'user_booking_template'=>env('POSTMARK_USER_BOOKING_TEMPLATE'),
         'manager_booking_status_change_template'=>env('POSTMARK_MANAGER_BOOKING_STATUS_CHANGE_TEMPLATE'),
         'user_booking_status_change_template'=>env('POSTMARK_USER_BOOKING_STATUS_CHANGE_TEMPLATE'),
        'user_verification_template'=>env('POSTMARK_USER_VERIFICATION_TEMPLATE'),
       'guest_verification_email'=>env('POSTMARK_GUEST_VERIFICATION_EMAIL'),
       'intake_reminder'=>env('POSTMARK_INTAKE_REMINDER'),
       'monthly_reminder'=>env('POSTMARK_MONTHLY_REMINDER'),
       'referral_email'=>env('POSTMARK_REFERRAL_REMINDER'),
        'referral_update'=>env('POSTMARK_REFERRAL_UPDATE'),
        'old_referral_update'=> env('POSTMARK_OLD_REFERRAL_UPDATE'),
    ],

    'static_variables'=>[
        'product_url'=>env('POSTMARK_PRODUCT_URL'),
        'product_logo'=>env('POSTMARK_PRODUCT_LOGO'),
        'product_name'=>env('POSTMARK_PRODUCT_NAME'),
        'support_url'=>env('POSTMARK_SUPPORT_URL'),
        'thrivr_facebook'=>env('POSTMARK_THRIVR_FACEBOOK'),
        'thrivr_instagram'=>env('POSTMARK_THRIVR_INSTAGRAM'),
        'thrivr_twitter'=>env('POSTMARK_THRIVR_TWITTER'),
        'thrivr_linkedin'=>env('POSTMARK_THRIVR_LINKEDIN'),
        'company_name'=>env('POSTMARK_COMPANY_NAME'),
       
    ]



];
