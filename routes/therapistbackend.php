<?php

Route::group(
	['middleware' => ['auth:managersapi']],
	function () {

   

      //BOOKING MODIFICATION ROUTES
      //split payment types

        Route::prefix('booking/{booking:timekit_booking_id}/modify')->group(function () {
              //split payment-types
            Route::post('/payment-types','Managersapi\Booking\ModifyBookingController@splitPaymentTypes');
            Route::post('/tip','Managersapi\Booking\ModifyBookingController@addTip');
            Route::post('/modality','Managersapi\Booking\ModifyBookingController@updateModality');
            Route::post('/delete','Managersapi\Booking\ModifyBookingController@delete');

  });






        Route::post('/booking/{booking}/modify/confirm', 'Managersapi\Booking\ManagerBookingController@confirmModify')->name('modify.confirm.therapist');
		    Route::post('/bookings/{booking:timekit_booking_id}/modify','Managersapi\Booking\ManagerBookingController@modify');
 		    Route::get('/bookings/receipt/{booking:timekit_booking_id}', 'Managersapi\Booking\ReceiptController@send');
		  

        Route::get('/analytics/google/{days}', 'Managersapi\Analytics\TherapistGoogleAnalyticsController@get');
        Route::get('/analytics/{days}', 'Managersapi\Analytics\TherapistAnalyticsController@get');
		    Route::get('/bookings/{booking:timekit_booking_id}','Managersapi\Booking\BookingListingsController@show');
    	   Route::group(['middleware' => ['userType']], function () {
             Route::post('/clients/{instauuid}/email','Managersapi\Forms\IntakeFormController@email');
  		        Route::post('/clients/unblock/{instauuid}','Managersapi\Clients\BlockClientController@unblock');
  		        Route::post('/clients/block/{instauuid}','Managersapi\Clients\BlockClientController@block');
  		//New
  		Route::get('/clients/{instauuid}/analytics','Managersapi\Clients\ClientAnalyticsController@getClientAnalytics');
  		Route::get('/clients/{instauuid}/bookings','Managersapi\Booking\BookingListingsController@clientsBookingWithTherapist');
  		Route::post('/clients/{instauuid}/email/resend', 'Managersapi\Clients\GuestController@resendEmail')->name('guest.verification.resend');
  		//END NEW
  		Route::get('/clients/intake-form/{instauuid}','Managersapi\Forms\IntakeFormController@list');
  		
  		Route::get('/clients/{instauuid}','Managersapi\Clients\ClientListingsController@detail');

  		
  	    Route::post('/book/{project}/{managerspeciality}/{instauuid}', 'Managersapi\Booking\ManagerBookingController@book');

             Route::prefix('clients/{instauuid}/charts')->group(function () {
              //split payment-types
            Route::get('/','Managersapi\Charts\TherapistChartController@list');
            Route::post('/create','Managersapi\Charts\TherapistChartController@create');
           
Route::prefix('{chart:id}')->group(function () {
            Route::get('/','Managersapi\Charts\TherapistChartController@detail');
            Route::post('/lock','Managersapi\Charts\TherapistChartController@lock');
            Route::post('/edit','Managersapi\Charts\TherapistChartController@edit');
            Route::post('/ammend','Managersapi\Charts\TherapistChartController@append');
       });    

  });


			});

		Route::get('/bookings','Managersapi\Booking\BookingListingsController@list');
		Route::get('/reviews','Managersapi\Reviews\ReviewsController@list');	

		//
        Route::post('/guests/{guest:instauuid}','Managersapi\Clients\GuestController@update');
    Route::post('/guests','Managersapi\Clients\GuestController@store');	
     
		Route::get('/clients','Managersapi\Clients\ClientListingsController@list');	
       
		//timekit endpoints
		Route::post('/therapist-durations/update', 'Managersapi\TherapistProjectsController@update');
		Route::get('/therapist-durations', 'Managersapi\TherapistProjectsController@list');
		Route::post('/licenses/create', 'Managersapi\License\TherapistLicenseContoller@create');
		Route::get('/licenses', 'Managersapi\License\TherapistLicenseContoller@list');
		Route::post('/notifications/update', 'Managersapi\ManagersNotificationController@update');
		Route::get('/notifications', 'Managersapi\ManagersNotificationController@list');
		Route::post('/availability-constraints/update', 'Managersapi\AvailabilityConstraint\AvailabilityConstraintController@updateAvailabilityConstraint');
		Route::get('/availability-constraints', 'Managersapi\AvailabilityConstraint\AvailabilityConstraintController@getAvailabilityConstraint');
		Route::post('/modalities/update', 'Managersapi\Modalities\TherapistModalitiesController@updateModalities');
   
    Route::post('/sub-modalities/update', 'Managersapi\Modalities\TherapistSubModalitiesController@updateSubModalities');
   Route::get('/your-sub-modalities', 'Managersapi\Modalities\TherapistSubModalitiesController@getTherapistSubModaliies');
		Route::get('/your-modalities', 'Managersapi\Modalities\TherapistModalitiesController@getTherapistModaliies');	
		Route::post('/set/password','Managersapi\AuthManagersController@setPassword');
		Route::post('/avatar/update', 'Managersapi\TherapistProfileController@uploadImage');
		Route::post('/first-login', 'Managersapi\TherapistProfileController@firstLogin');
		Route::post('/profile/create', 'Managersapi\TherapistProfileController@storeTherapistProfile');
		Route::post('/bio/update', 'Managersapi\TherapistProfileController@updateTherapistProfile');
		Route::post('/profile/update', 'Managersapi\TherapistProfileController@updateTherapist');
		Route::get('/profile', 'Managersapi\TherapistProfileController@getTherapistProfile');	
		Route::post('/tutorial', 'Managersapi\TherapistProfileController@tutorialComplete');	
			//Route::post('/profile', 'Managersapi\TimekitController@setResourceTimeConstraints');
		//	Route::post('/availability', 'Managersapi\TimekitController@setResourceTimeConstraints');
		Route::get('/availability/{project}/{startDateTime}/{endDateTime}', 'Managersapi\AvailabilityConstraint\AvailabilityController@slots');
		Route::get('/availability', 'Managersapi\TimekitController@getResourceTimeConstraints');
		Route::get('/check-auth', 'Managersapi\AuthManagersController@checkAuth');
		Route::post('/logout', 'Managersapi\AuthManagersController@logoutTherapist');


    //old routes
    Route::post('/therapist/avatar/update', 'Managersapi\TherapistProfileController@uploadImage');
    Route::post('/therapist/first-login', 'Managersapi\TherapistProfileController@firstLogin');
    Route::post('/therapist/profile/create', 'Managersapi\TherapistProfileController@storeTherapistProfile');
    Route::post('/therapist/profile/update', 'Managersapi\TherapistProfileController@updateTherapistProfile');
    Route::post('/therapist/update', 'Managersapi\TherapistProfileController@updateTherapist');
   
 

	}
);



    Route::get('/payment-types', 'Common\PaymentTypeController@index');	
   Route::post('/register', 'Managersapi\RegisterController@register');
	Route::post('/login', 'Managersapi\AuthManagersController@loginTherapist');
	Route::post('/refresh', 'Managersapi\AuthManagersController@refreshPassportToken');
	Route::post('/password/forgot', 'Managersapi\ForgotPasswordController@sendResetLinkEmail');
	Route::post('/reset-password', 'Managersapi\ResetPasswordController@reset');
  	Route::get('/modalities', 'Managersapi\Modalities\TherapistModalitiesController@getAllModalities');
    Route::get('/durations', 'Managersapi\TherapistProjectsController@getAllProjects');
    Route::get('/endorsements', 'EndorsementController@index');
 Route::get('/sub-modalities', 'Managersapi\Modalities\TherapistSubModalitiesController@list');


//webhooks
		