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


Route::prefix('/')->group(function () {
    Route::get('/city-banner', 'CityBannerController@index');
    Route::post('contact-us', 'ContactFormController@store');
    Route::post('ctarecord', 'CTARecordController@store');
    Route::post('request-demo/{timezone}', 'DemoController@store');
    Route::get('request-demo/{timezone}/{demodate}', 'DemoController@list');
    Route::get('sitemap','ListTherapistRoutesController@index');
    Route::get('/thrivr-form-flows', 'FormsController@handleEmailFlow')->name('form.workflow')->middleware('customSigned:consume');

    Route::get('guest/email/accept/{id}/{hash}', 'GuestVerificationApiController@accept')->name('verification.verify.guest.acceptance')->middleware('api');
    Route::post('guest/email/verify/{id}/{hash}', 'Usersapi\v2\RegisterController@verify')->name('verification.verify.guest')->middleware('api');
    Route::get('email/verify/{id}/{hash}', 'VerificationApiController@verify')->name('verification.verify');
    Route::get('/unsubscribe/guest/{instauuid}', 'Usersapi\v2\UnsubscribeController@unsubscribeGuest')->name('unsubscribe.guest')->middleware('api');
    Route::get('/unsubscribe/user/{instauuid}', 'Usersapi\v2\UnsubscribeController@unsubscribeUser')->name('unsubscribe.user')->middleware('api');
    Route::get('/unsubscribe/guest/future/{instauuid}', 'Usersapi\v2\UnsubscribeController@unsubscribeFutureGuest')->name('unsubscribe.future.guest')->middleware('api');
    Route::get('/unsubscribe/user/future/{instauuid}', 'Usersapi\v2\UnsubscribeController@unsubscribeFutureUser')->name('unsubscribe.future.user')->middleware('api');
    Route::get('/unsubscribe/user/update/{instauuid}', 'Usersapi\v2\UnsubscribeController@unsubscribeUpdateUser')->name('unsubscribe.update.user')->middleware('api');

});
/*
Route::get('/therapistlogin', function(){ 
     return Redirect::to(config('therapistadmin.url'), 302); 
})->name('therapistlogin');
Route::get('/reactapp', function(){ 
     return Redirect::to(config('therapistadmin.url'), 302); 
});

Route::namespace('Studio')->prefix(config('studio.path'))->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', 'PostController@index');
            Route::get('{identifier}/{slug}', 'PostController@show')->middleware('Canvas\Http\Middleware\Session');
        });

        Route::prefix('tags')->group(function () {
            Route::get('/', 'TagController@index');
            Route::get('{slug}', 'TagController@show');
        });

        Route::prefix('topics')->group(function () {
            Route::get('/', 'TopicController@index');
            Route::get('{slug}', 'TopicController@show');
        });

        Route::prefix('users')->group(function () {
            Route::get('{identifier}', 'UserController@show');
        });
    });

    Route::get('/{view?}', 'ViewController')->where('view', '(.*)')->name('studio');
});

*/

Route::fallback( function(){ 
  return Redirect::to(config('constants.urls.webapp'), 302); 
});
