<?php

return [
    'urls' => [
        'timekitapi' => 'https://api.timekit.io/v2',
        'valet' => 'http://instawalkin.test',
        'passportLogin' => '/oauth/token',
        'valet_share' => 'http://1ad75e69.ngrok.io',
        'webapp'=>env('WEBAPP')
    ],
    'notifications' => [
        //THESE ARE CONSTANTS FOR NOTIFICATIONs
        'notification_booking_success' => env('MIX_NOTIFICATION_BOOKING_SUCCESS', 'MIX_NOTIFICATION_BOOKING_SUCCESS'),
        'notification_booking_failure' => env('MIX_NOTIFICATION_BOOKING_FAILURE', 'MIX_NOTIFICATION_BOOKING_FAILURE'),
        'notification_credit_card_error' => env('MIX_NOTIFICATION_CREDIT_CARD_ERROR', 'MIX_NOTIFICATION_CREDIT_CARD_ERROR'),
        'notification_booking_rescheduled' => env('MIX_NOTIFICATION_BOOKING_RESCHEDULED', 'MIX_NOTIFICATION_BOOKING_RESCHEDULED'),
        'notification_booking_cancelled' => env('MIX_NOTIFICATION_BOOKING_CANCELLED', 'MIX_NOTIFICATION_BOOKING_CANCELLED'),
        'notification_receipt'=>env('MIX_NOTIFICATION_RECEIPT','MIX_NOTIFICATION_RECEIPT'),
        'notification_unknownException'=>env('MIX_NOTIFICATION_UNKNOWN_EXCEPTION','MIX_NOTIFICATION_UNKNOWN_EXCEPTION'),
        'testing_email'=>env('CUSTOMER_RECEIPT_DEV', 'marco.maigua@instawalkin.com')
    ],
    'configurations'=>[
        'timekit_dev_key'=> env('TIMEKIT_DEV_KEY', 'non existent'),
        'bookable_type_user'=>env('MIX_BOOKABLE_TYPE_USER', 'App\User'),
        'bookable_type_guest'=>env('MIX_BOOKABLE_TYPE_GUEST', 'App\Guest'),
        'payment_type_cash'=> env('MIX_PAYMENT_TYPE_CASH', 'CA'),
        'payment_type_credit'=>env('MIX_PAYMENT_TYPE_CREDIT', 'CR'),
        'payment_type_cash_string'=> env('MIX_PAYMENT_TYPE_CASH_STRING', 'CASH'),
        'payment_type_credit_string'=>env('MIX_PAYMENT_TYPE_CREDIT_STRING', 'CREDIT'),
        'by_source_users'=>env('MIX_BY_SOURCE_USERS', 'USER'),
        'by_source_therapist'=> env("MIX_BY_SOURCE_THERAPISTS", 'THERAPIST'),
        'cancel_fee_percentage'=> env('MIX_CANCEL_FEE_PERCENTAGE', 1),
        'reschedule_fee_percentage'=>env('MIX_RESCHEDULE_FEE_PERCENTAGE', 0.5),
        'booking_status_cancellation'=>env('MIX_BOOKING_STATUS_CANCELLATION','C'),
        'booking_status_rescheduling'=>env('MIX_BOOKING_STATUS_RESCHEDULING','R'),
        'paid_by_credit'=>env('MIX_PAID_BY_CREDIT', 'CR'),
        'paid_by_cash'=>env('MIX_PAID_BY_CASH', 'CA'),
        'booking_status_charge'=>env('MIX_BOOKING_STATUS_CHARGE', 'CHARGE'),
        'booking_graph'=>env('MIX_BOOKING_GRAPH', 'instant'),
        'booking_customer_name'=>env('MIX_BOOKING_CUSTOMER_NAME', 'instawalkin'),
        'booking_customer_email'=>env('MIX_BOOKING_CUSTOMER_EMAIL', "marco.maigua@instawalkin.com"),
        'timekit_project_id'=>env('TIMEKIT_PROJECT_ID')
        
    ],
    'apis'=>[
        'stripe_secret'=>env('STRIPE_SECRET', 'pk_test_eLRzVe4NvBG1wgfHmYtPt0J7'),
        'stripe_api_version'=>env('STRIPE_API_VERSION', '2019-02-19')
    ],
    'passport_variables'=>[
'mix_user_client_id'=>env('MIX_CLIENT_USER_ID'),
'mix_user_client_secret'=>env('MIX_CLIENT_USER_SECRET'),
'passport_password_grant_client_id'=>env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
'passport_password_grant_client_secret'=>env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
'mix_client_id'=>env('MIX_CLIENT_ID'),
'mix_client_secret'=>env('MIX_CLIENT_SECRET', 'JelJdPoaOVDMyokftfYmusiTXnth5BnCMOO5IDiT')


    ],
    'timekit'=>[
'default_timekit_resource_id'=>env('DEFAULT_TIMEKIT_RESOURCE_ID'),

    ]

];
