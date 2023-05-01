<?php

/*use App\Notifications\UserBookingNotification;
use App\Notifications\ReceiptNotification;
use App\Guest;
use App\Booking;
use Carbon\Carbon;
 use App\Helpers\CustomStringHelper;

Route::get('/test', function () {
return CustomStringHelper::addBufferPlusMinutesString(CustomStringHelper::getFirstIntegerFromString('60 minutes'),'15 minutes');
});

/*Route::get('/test', function () {
    $booking=Booking::find(235);
  $guest=$booking->bookable;

  if($guest instanceof Guest){
    Log::debug("hello");
  }
  else{
    Log::debug("hello1");
  }




//  $booking->bookable->notifyAt(new UserBookingNotification($booking,true),Carbon::parse($booking->start,$booking->manager->timezone)->addMinutes(59));
  //$booking->bookable->notify(new UserBookingNotification($booking));
// $booking->bookable->notify(new ReceiptNotification($receipt));
});
/*
Route::get('/terms-of-service', function () {
    return response()->redirectTo("https://s3.ca-central-1.amazonaws.com/instawalkin-images/Contracts/InstaWalkinTermsofService.pdf");
})->name('terms');
Route::get('/privacy-policy', function () {
    return response()->redirectTo("https://s3.ca-central-1.amazonaws.com/instawalkin-images/Contracts/InstaWalkinPrivacyPolicy.pdf");
})->name('policy');


*/

use App\Booking;
use Illuminate\Support\Facades\Log;
use App\Notifications\UserBookingNotification;
Route::get('/updatePhone/{user:email}','Dev\DevController@updatePhoneToNull');
Route::get('/updateEmail/{user:email}','Dev\DevController@updateEmailToNull');  
Route::get('/updateEmailPhone/{user:email}','Dev\DevController@updateEmailPhoneToNull');
Route::get('/toggleBookingClose/{booking:id}','Dev\DevController@toggleBookingClose');
Route::get('/sendProductUpdate','Dev\DevController@sendProductUpdate');
Route::get('/test',function(){

    $booking=Booking::latest()->first();
    $booking->bookable->notify(new UserBookingNotification($booking));



});