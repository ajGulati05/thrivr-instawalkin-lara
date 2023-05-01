<?php
Route::group(
	['middleware' => ['refreshToken:managersapi'], 'prefix' => 'managersapi'],
	function () {

		Route::get('/testing',function(){
			return "hola";
		} );
		
		Route::post('/logout', 'Managersapi\AuthManagersController@logout')->name('managersapi.logout');
	
		//these routes are being used by the react app
		Route::post('/getTimekitResourceId', 'Managersapi\AuthManagersController@getTimekitResourceId')->name('managersapi.getTimekitResourceId');

		//Is this necessary? or will add latency? Sending time constraints through laravel nova first by clicking each time constraint
		Route::post('/setResourceTimeConstraints', 'Managersapi\TimekitController@setResourceTimeConstraints')->name('managersapi.setResourceTimeConstraints');
		Route::post('/getResourceTimeConstraints', 'Managersapi\TimekitController@getResourceTimeConstraints')->name('managersapi.getResourceTimeConstraints');
	
		Route::post('/getCustomersAndProjects','Managersapi\BookingController@getCustomersAndProjects')->name('managersapi.getCustomersAndProjects');
		Route::post('/saveNewUser','Managersapi\BookingController@saveNewUser')->name('managersapi.saveNewUser');
		Route::post('/saveBooking','Managersapi\BookingController@saveBooking')->name('managersapi.saveBooking');
		Route::post('/getBookingPricingsByBookingId','Managersapi\BookingController@getBookingPricingsByBookingId')->name('managersapi.getBookingPricingsByBookingId');
		Route::post('/create_receipt','Managersapi\BookingController@create_receipt')->name('managersapi.createReceipt');
	}
);

Route::group(['prefix' => 'managersapi'], function () {
  	Route::get('/password/reset', 'Manager\ForgotPasswordController@showLinkRequestForm')->name('managersapi.password.request');
	Route::post('/password/email', 'Manager\ForgotPasswordController@sendResetLinkEmail')->name('managersapi.password.email');
	Route::get('/password/reset/{token}', 'Manager\ResetPasswordController@showResetForm')->name('managersapi.password.reset');
	Route::post('/password/reset', 'Manager\ResetPasswordController@reset');


});
Route::get('/bookables', 'Managersapi\BookingController@bookables');
Route::post('/managersapi/loginTherapist', 'Managersapi\AuthManagersController@loginTherapist')->name('managersapi.loginTherapist');

//webhooks
Route::post('/timekit_booking_webhook','Managersapi\WebHooksController@timekit_booking_webhook')->name('managersapi.timekit_booking_webhook');
