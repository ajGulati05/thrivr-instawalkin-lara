<?php



Route::group(

    ['middleware' => ['AddPassportParams', 'refreshToken:usersapi'], 'prefix' => 'usersapi'],
    function () {

        Route::get('/checkAuth', 'Usersapi\UserProfileController@checkAuth');
        Route::post('/updateUserProfile', 'Usersapi\UserProfileController@update');

        Route::get('/getNotificationSettings', 'Usersapi\UserNotificationsController@getNotificationSettings');
        Route::post('/postNotificationSettings', 'Usersapi\UserNotificationsController@postNotificationSettings');
        Route::get('/getPaymentOptions', 'Usersapi\UserProfileController@getPaymentOptions');
        Route::get('/getUserProfile', 'Usersapi\UserProfileController@getUserProfile');
        Route::get('/logout', 'Usersapi\AuthUsersController@logoutUser'); //this needs a guard defined in routes
        Route::post('/editUser', 'Usersapi\AuthUsersController@editUser')->name('usersapi.editUser'); //this needs a guard defined in routes
        // needs testing
        //booking routes
        Route::post('/postTip', 'Usersapi\BookingController@postTip')->name('usersapi.postTip');
        Route::get('/getAllBookings', 'Usersapi\BookingController@getAllBookings');
        Route::post('/book', 'Usersapi\BookingController@book')->name('usersapi.book');
        Route::post('/updateCreateStripeCreditCard', 'Usersapi\StripeDatasController@store')->name('usersapi.updateCreateStripeCreditCard');
        Route::post('/deleteStripeCard', 'Usersapi\StripeDatasController@destroy');

       Route::post('/create_receipt', 'Usersapi\BookingController@create_receipt')->name('usersapi.create_receipt');
        Route::post('/cancelBook', 'Usersapi\BookingController@cancelBook')->name('usersapi.cancelBook');
        Route::post('/rescheduleBook', 'Usersapi\BookingController@rescheduleBook')->name('usersapi.rescheduleBook');
    }
);


Route::group(
    ['middleware' => ['AddPassportParams'], 'prefix' => 'usersapi'],
    function () {
        //this needs a guard defined in routes
        
        Route::post('/login', 'Usersapi\AuthUsersController@loginUser')->name('usersapi.login'); //this needs a guard defined in routes
    }
);


Route::group(['prefix' => 'usersapi'], function () {
    Route::post('/forgotpassword', 'UserAuthMobile\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/password/reset', 'UserAuthMobile\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('/password/reset/{token}', 'UserAuthMobile\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'UserAuthMobile\ResetPasswordController@reset');
    Route::post('/registerUser', 'Usersapi\AuthUsersController@registerUser')->name('usersapi.registerUser');
    Route::get('/getAllProjectsAndPricing', 'ProjectPricingController@getAllProjectsAndPricing')->name('usersapi.getAllProjectsAndPricing');
    Route::get('/getAllSpecialities', 'Usersapi\ManagerSpecialitiesController@getAllSpecialities')->name('usersapi.getAllSpecialities');
    Route::post('/getOpenSlotsByDate', 'Usersapi\BookingController@getOpenSlotsByDate')->name('usersapi.getOpenSlotsByDate');
});

