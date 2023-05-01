<?php

Route::prefix('usersapi')->group(function () {
	Route::get('/locationtypes', 'LocationtypesController@getLocationTypes');
	Route::post('/locationResource', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@getLocationResource']);
	Route::post('/login', 'UserAuthMobile\LoginController@login')->name('usersapi.login');
	Route::post('/register', 'UserAuthMobile\RegisterController@register')->name('usersapi.register');
	Route::patch('/profile', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@update']);
	Route::post('/applypromo', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@applyPromoCode']);
	Route::patch('/profilechecks', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@updateChecks']);
	Route::post('/password/email', 'UserAuthMobile\ForgotPasswordController@sendResetLinkEmail');
	Route::get('/password/reset', 'UserAuthMobile\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::get('/password/reset/{token}', 'UserAuthMobile\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('/password/reset', 'UserAuthMobile\ResetPasswordController@reset');
	Route::post('/profile', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@store']);
	Route::get('/refresh', ['before' => 'jwt-refresh', 'uses' => 'UserAuthMobile\LoginController@refresh']);
	Route::post('/instawalkinstripe', ['before' => 'jwt-auth', 'uses' => 'StripedataController@store']);
	Route::post('/instawalkinstripe/destroy', ['before' => 'jwt-auth', 'uses' => 'StripedataController@destroy']);

	Route::patch('/notificationsupdate', ['before' => 'jwt-auth', 'uses' => 'UserNotificationsController@update']);
	Route::post('/notifications', ['before' => 'jwt-auth', 'uses' => 'UserNotificationsController@store']);
	Route::post('/addtip', ['before' => 'jwt-auth', 'uses' => 'StripedataController@addtip']);
	Route::get('/history', ['before' => 'jwt-auth', 'uses' => 'UserApiController\UserHistoryController@getUserHistory']);
	Route::patch('/updateExpoToken', ['before' => 'jwt-auth', 'uses' => 'UserprofileController@updateExpoToken']);
});


Route::prefix('usersapiv2')->group(function () {
	Route::get('/locationtypes', 'LocationtypesController@getLocationTypes');
	Route::post('/login', 'UserAuthMobile\LoginController@login');
	Route::post('/register', 'UserAuthMobile\RegisterController@register');
	Route::post('/password/email', 'UserAuthMobile\ForgotPasswordController@sendResetLinkEmail');


	//need to use JWT AUTH Refresh
	Route::post('/locationResource', 'UserprofileController@getLocationResource')->middleware('refreshToken');
	Route::patch('/profile', 'UserprofileController@update')->middleware('refreshToken');
	Route::post('/applypromo', 'UserprofileController@applyPromoCode')->middleware('refreshToken');
	Route::get('/getpromocodes', 'UserprofileController@GetPromoCodes')->middleware('refreshToken');
	Route::patch('/profilechecks', 'UserprofileController@updateChecks')->middleware('refreshToken');

	Route::get('/refreshcredits', 'UserprofileController@refreshCredits')->middleware('refreshToken');
	Route::post('/profile', 'UserprofileController@store')->middleware('refreshToken');
	Route::get('/refresh', 'UserAuthMobile\LoginController@reload')->middleware('refreshToken');
	Route::post('/instawalkinstripe', 'StripedataController@store')->middleware('refreshToken');
	Route::post('/instawalkinstripe/destroy', 'StripedataController@destroy')->middleware('refreshToken');

	Route::patch('/notificationsupdate', 'UserNotificationsController@update')->middleware('refreshToken');
	Route::post('/notifications', 'UserNotificationsController@store')->middleware('refreshToken');
	Route::post('/addtip', 'StripedataController@addtip')->middleware('refreshToken');
	Route::post('/addreview', 'ReviewController@store')->middleware('refreshToken');
	Route::get('/history', 'UserApiController\UserHistoryController@getUserHistory')->middleware('refreshToken');
	Route::get('/recenthistory', 'UserApiController\UserHistoryController@getRecentUserHistory')->middleware('refreshToken');
	Route::patch('/updateExpoToken', 'UserprofileController@updateExpoToken')->middleware('refreshToken');
});


Route::prefix('usersapiv3')->group(function () {
	Route::get('/instaprices', 'InstapriceController@getServiceCategoryV3');
	Route::get('/appconfig', 'AppconfigController@show');
	Route::get('/getcreditsorpromo', 'UserprofileController@getcreditsorpromo');
	Route::post('/login', 'UserAuthMobile\LoginController@login');
	Route::post('/register', 'UserAuthMobile\RegisterController@register');
	Route::post('/password/email', 'UserAuthMobile\ForgotPasswordController@sendResetLinkEmail');


	//need to use JWT AUTH Refresh
	Route::post('/locationResource', 'UserprofileController@getLocationResource')->middleware('refreshToken');
	Route::patch('/profile', 'UserprofileController@update')->middleware('refreshToken');
	Route::post('/applypromo', 'UserprofileController@applyPromoCode')->middleware('refreshToken');
	Route::get('/getpromocodes', 'UserprofileController@GetPromoCodes')->middleware('refreshToken');
	Route::patch('/profilechecks', 'UserprofileController@updateChecks')->middleware('refreshToken');

	Route::get('/refreshcredits', 'UserprofileController@refreshCredits')->middleware('refreshToken');
	Route::post('/profile', 'UserprofileController@store')->middleware('refreshToken');
	Route::get('/refresh', 'UserAuthMobile\LoginController@reload')->middleware('refreshToken');
	Route::post('/instawalkinstripe', 'StripedataController@store')->middleware('refreshToken');
	Route::post('/instawalkinstripe/destroy', 'StripedataController@destroy')->middleware('refreshToken');

	Route::patch('/notificationsupdate', 'UserNotificationsController@update')->middleware('refreshToken');
	Route::post('/notifications', 'UserNotificationsController@store')->middleware('refreshToken');
	Route::post('/addtip', 'StripedataController@addtip')->middleware('refreshToken');
	Route::post('/addreview', 'ReviewController@store')->middleware('refreshToken');
	Route::get('/history', 'UserApiController\UserHistoryController@getUserHistory')->middleware('refreshToken');

	Route::get('/getRecentUnreadHistory', 'UserApiController\UserHistoryController@getRecentUnreadHistory')->middleware('refreshToken');
	Route::patch('/updateExpoToken', 'UserprofileController@updateExpoNewToken')->middleware('refreshToken');
	Route::get('/getUnreadHoldingTransactions', 'HoldingtransactionsController@getUnreadHoldingTransactions')->middleware('refreshToken');

	Route::get('/getRecentUnreadNotifications', 'NotificationSentController@getRecentUnreadNotifications')->middleware('refreshToken');
	Route::post('/setNotificationsToRead', 'NotificationSentController@update')->middleware('refreshToken');
});