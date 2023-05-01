<?php

namespace App\Http\Controllers\Managersapi;

use App\Events\BookingSuccessEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WebHooksController extends Controller
{
    public function timekit_booking_webhook(Request $request){
        Log::debug('REQUEST');

        Log::debug($request);

        $request= 'booking test';
        event(new BookingSuccessEvent($request));
    }
}
