<?php


Route::group(

    ['middleware' => ['auth:usersapi'], 'prefix' => 'v2'],
    function () {
        
        Route::prefix('/referral')->group(function(){
            //get referral rewards
            Route::get('/rewards/list','Usersapi\v2\Referral\UserReferralController@rewardsList');
            Route::get('/rewards','Usersapi\v2\Referral\UserReferralController@totalRewards');

            Route::post('/email','Usersapi\v2\Referral\UserReferralEmailController@invite');

            //send referral email

            //get referral reward




        });


       Route::get('/intake-forms/{intake_form}','Usersapi\v2\IntakeFormController@detail');
          Route::prefix('promo-codes/{code}')->group(function () {
            Route::get('/','Usersapi\v2\PromoCodes\PromoCodeController@canUsePromoCode');
        
        });

   

        Route::post('/email/resend', 'VerificationApiController@resend')->name('verification.resend');
        Route::get('/intake-forms/{intake_form}','Usersapi\v2\IntakeFormController@detail');
        Route::get('/intake-forms','Usersapi\v2\IntakeFormController@list');   
        Route::post('/intake-forms','Usersapi\v2\IntakeFormController@store');
        Route::post('/cart-views/{manager:slug}', 'Usersapi\v2\CartViewController@store');
        Route::post('/guests', 'Usersapi\v2\UserGuestController@store')->middleware('dencryptForm');
        Route::get('/guests', 'Usersapi\v2\UserGuestController@list');
         
        Route::post('/booking/{booking}/modify/confirm', 'Usersapi\v2\UsersBookingController@confirmModify')->name('modify.confirm');
        Route::post('/booking/{booking:timekit_booking_id}/modify', 'Usersapi\v2\UsersBookingController@modify');
        Route::post('/review/booking/{booking:timekit_booking_id}', 'Usersapi\v2\ReviewController@createReviewForBooking');
        Route::post('/review/therapist/{manager:slug}', 'Usersapi\v2\ReviewController@createReviewForTherapist');
        Route::post('/booking/{booking:timekit_booking_id}/receipt', 'Usersapi\v2\BookingController@receipt');
        Route::post('/booking/{booking:timekit_booking_id}/tip', 'Usersapi\v2\BookingController@tip');
        Route::get('/booking/{booking:timekit_booking_id}', 'Usersapi\v2\BookingController@detail');
        Route::get('/bookings', 'Usersapi\v2\BookingController@list');
        Route::get('/notifications','Usersapi\v2\UserNotificationsController@list');
        Route::post('/notifications/update','Usersapi\v2\UserNotificationsController@updateWeb');
        Route::post('/set/password','Usersapi\v2\AuthUsersController@setPassword');
        Route::post('/book/{project}/{manager:slug}/{managerspeciality:code}', 'Usersapi\v2\UsersBookingController@book');
        Route::get('/check-auth', 'Usersapi\v2\AuthUsersController@checkAuth');
        Route::get('/credit-cards', 'Usersapi\v2\CreditCardController@index');
        Route::post('/credit-cards/delete/{card}', 'Usersapi\v2\CreditCardController@destroy');
        Route::post('/credit-cards/default/{card}', 'Usersapi\v2\CreditCardController@setCardToDefault');
        Route::post('/credit-cards/create', 'Usersapi\v2\CreditCardController@store');
        Route::post('/recommended-rmt-signed','Usersapi\v2\UserRecommendedRmtController@storeWithAuth');
        Route::get('/userprofile', 'Usersapi\v2\UserProfileController@getUserProfile');
        Route::post('/userprofile/update/email', 'Usersapi\v2\UserProfileController@emaiUpdate');
        Route::post('/userprofile/image/update', 'Usersapi\v2\UserProfileController@uploadImage');
        Route::post('/userprofile/update', 'Usersapi\v2\UserProfileController@update');
        Route::post('/logout', 'Usersapi\v2\AuthUsersController@logoutUser');
       // Route::put('/user/{id}', 'Usersapi\v2\UserController@update');
    }
);





Route::group(['middleware' => ['web'],'prefix' => 'v2'], function () {
     
    Route::get('/intake-forms/email/{booking:timekit_booking_id}/signed','Usersapi\v2\UsersBookingController@emailIntakeForms');
    Route::post('/login', 'Usersapi\v2\AuthUsersController@loginUser');//this needs a guard defined in routes
    Route::post('/refresh', 'Usersapi\v2\AuthUsersController@refreshPassportToken');
	Route::post('/register', 'Usersapi\v2\RegisterController@register');
    Route::post('/social-auth', 'Usersapi\v2\SocialAuthController@handleSocial');
    Route::post('/password/forgot', 'Usersapi\v2\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Usersapi\v2\ResetPasswordController@reset');
    Route::get('/project-pricings', 'Usersapi\v2\ProjectPricingController@index');
     Route::get('/project-pricings/{manager:slug}', 'Usersapi\v2\ProjectPricingController@getIndividualProjects');
    Route::get('/specialities', 'Usersapi\v2\ManagerSpecialitiesController@index');
    Route::get('/availability/{project}/{startDateTime}/{timeZone}/{lattitude}/{longitude}', 'Usersapi\v2\AvailabilityController@index');
    Route::get('/launched-cities', 'LaunchedCitiesController@index');
    Route::post('/recommended-rmt','Usersapi\v2\UserRecommendedRmtController@store');
     Route::get('/endorsements', 'EndorsementController@index');
    Route::get('/therapist/{manager:slug}/reviews/{itemcount}/{sort}', 'Usersapi\v2\ReviewController@index');
    Route::get('/therapist/{manager:slug}/endorsements', 'Usersapi\v2\UserEndorsementController@index');
    Route::get('{manager:slug}/availability/{project}/{startDateTime}/{includeProfile}', 'Usersapi\v2\AvailabilityController@slots');

    Route::get('/massage-practice/{launched_cities}/{rmt_team}/{project}/{startDateTime}', 'Usersapi\v2\AvailabilityController@teamSlots');
    Route::get('/massage-therapists/{launched_cities}/{project}/{startDateTime}', 'Usersapi\v2\AvailabilityController@citySlots');
  
     Route::post('/covid-forms/create', 'CovidFormController@resolveCreateOrConsent')->name('cform.intake')->middleware('customSigned:consume,absolute','userType','dencryptForm');
    Route::post('/intake-forms/create', 'IntakeFormController@resolveCreateOrConsent')->name('form.intake')->middleware('customSigned:consume,absolute','userType','dencryptForm');

   

});

