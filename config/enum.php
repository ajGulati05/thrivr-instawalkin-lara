<?php



return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. The minimum
    | required options are declared here, but the full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */


    'httpRequests' => [
        'get'    => 'get',
        'post' => 'post',
        'put'=>'put',
        'delete'=>'delete',
        'pool'=>'pool'
    ],


  
];
