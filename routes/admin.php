
<?php

//admin routes
Route::get('/admininstawalkin/login', 'AdminAuth\LoginController@showLoginForm');
Route::post('/admininstawalkin/login', 'AdminAuth\LoginController@login')->name('admin.login');

//Route::post('/admininstawalkin/register','AdminAuth\RegisterController@register')->name('admin.register');
//Route::get('/admininstawalkin/register','AdminAuth\RegisterController@showRegistrationForm');

Route::middleware('auth:admin')->prefix('admininstawalkin')->group(function () {

	//Route::get('/massemail','AdminController@fireMassEmail');
	Route::get('/partnerform', 'AdminController@getBecomeAPartnerFrom')->name('admin.partnerform');
	Route::get('/contactform', 'AdminController@getContactForm')->name('admin.contactform');
	Route::get('/betasignup', 'AdminController@getBetaSignup')->name('admin.betasignup');
	//Route::get('/transactions','AdminController@getTransactions')->name('admin.transactions');
	Route::post('/admininstawalkin/logout', 'AdminAuth\LoginController@login')->name('admin.logout');

	Route::get('/locations/restoremodel/{location}', 'AdminLocationController@restoremodel')->name('admin.locations.restoremodel');
	Route::get('/locations/softdelete/{location}', 'AdminLocationController@destroy')->name('admin.locations.destroy');
	Route::get('/locations/attach/{location}/{locationtype}', 'AdminLocationController@attach')->name('admin.locations.attach');
	Route::get('/locations/dettach/{location}/{locationtype}', 'AdminLocationController@detach')->name('admin.locations.detach');
	Route::post('/locations/update/{location}', 'AdminLocationController@update')->name('admin.locations.update');
	Route::get('/locations', 'AdminLocationController@index')->name('admin.locations');
	Route::get('/locations/create/{managerid}', 'AdminLocationController@create')->name('admin.locations.create');
	Route::get('/locations/whatpagetoshow/{id}/{managerid}', 'AdminLocationController@whatpage')->name('admin.locations.whatpage');
	Route::get('/locations/show/{locationid}', 'AdminLocationController@show')->name('admin.locations.show');
	Route::post('/locations/{managerid}', 'AdminLocationController@store')->name('admin.locations.store');

	Route::get('/redis/create/{partner}', 'AdminController@redisCreate')->name('admin.redis.create');
	Route::post('/redis/update/{partner}', 'AdminController@redisUpdate')->name('admin.redis.update');
	//instaprices


	Route::get('/instaprices', 'InstapriceController@index')->name('admin.instaprices');
	Route::get('/instaprices/create', 'InstapriceController@create')->name('admin.instaprices.create');
	Route::get('/instaprices/show/{instaprice}', 'InstapriceController@show')->name('admin.instaprices.show');
	Route::post('/instaprices', 'InstapriceController@store')->name('admin.instaprices.store');
	Route::post('/instaprices/update/{instaprice}', 'InstapriceController@update')->name('admin.instaprices.update');

	//services
	Route::get('/services/restoremodel/{service}', 'AdminServicesController@restoremodel')->name('admin.services.restoremodel');
	Route::get('/services/softdelete/{service}', 'AdminServicesController@destroy')->name('admin.services.destroy');
	Route::get('{locationid}/services', 'AdminServicesController@index')->name('admin.services');
	Route::get('/{locationid}/services/create/', 'AdminServicesController@create')->name('admin.services.create');
	Route::get('/services/show/{service}', 'AdminServicesController@show')->name('admin.services.show');
	Route::post('/{locationid}/services', 'AdminServicesController@store')->name('admin.services.store');
	Route::post('/services/{services}', 'AdminServicesController@update')->name('admin.services.update');
	Route::get('/services/attach/{service}/{taxes}', 'AdminServicesController@attach')->name('admin.services.attach');
	Route::get('/services/dettach/{service}/{taxes}', 'AdminServicesController@detach')->name('admin.services.detach');
	//promocodes

	Route::get('/promocodes', 'AdminPromoCodesController@index')->name('admin.promocodes');
	Route::get('/promocodes/create/', 'AdminPromoCodesController@create')->name('admin.promocodes.create');
	Route::get('/promocodes/show/{promocode}', 'AdminPromoCodesController@show')->name('admin.promocodes.show');
	Route::post('/promocodes', 'AdminPromoCodesController@store')->name('admin.promocodes.store');
	Route::delete('/promocodes/delete/{promocode}', 'AdminPromoCodesController@destroy')->name('admin.promocodes.destroy');
	Route::post('/promocodes/update/{promocode}', 'AdminPromoCodesController@update')->name('admin.promocodes.update');

	//Daily Promo Codes
	Route::get('/dailypromo', 'DailypromoController@index')->name('admin.dailypromo');
	Route::get('/dailypromo/create/', 'DailypromoController@create')->name('admin.dailypromo.create');
	Route::post('/dailypromo', 'DailypromoController@store')->name('admin.dailypromo.store');
	//percentages


	Route::get('{locationid}/percentages', 'AdminLocationpercentagesController@index')->name('admin.percentages');
	Route::get('/{locationid}/percentages/create/', 'AdminLocationpercentagesController@create')->name('admin.percentages.create');
	Route::get('/percentages/show/{percentage}', 'AdminLocationpercentagesController@show')->name('admin.percentages.show');
	Route::post('/{locationid}/percentages', 'AdminLocationpercentagesController@store')->name('admin.percentages.store');
	//transactions


	Route::get('transactions/{locationid}', 'AdminLocationTransactionsController@index')->name('admin.transactions');
	//Route::get('/{locationid}/percentages/create/','AdminLocationpercentagesController@create')->name('admin.percentages.create');
	Route::get('/transactions/show/{transactionid}', 'AdminLocationTransactionsController@show')->name('admin.transactions.show');
	Route::get('/transactions/show/{transactionid}/user/{userid}', 'AdminLocationTransactionsController@transactionUser')->name('admin.transactions.showuser');
	//Route::post('/{locationid}/percentages','AdminLocationpercentagesController@store')->name('admin.percentages.store');


	//holding transactions
	Route::get('/holdingtransactions', 'HoldingtransactionsController@index')->name('admin.holdingtransactions');
	Route::get('/holdingtransactions/show/{holdingtransactions}', 'HoldingtransactionsController@show')->name('admin.holdingtransactions.show');
	Route::post('/holdingtransactions/update/{holdingtransactions}', 'HoldingtransactionsController@update')->name('admin.holdingtransactions.update');
	//users


	Route::get('users/{user}', 'AdminUserController@index')->name('admin.user');
	Route::post('users/addcredit/{transactionid}/{userid}', 'AdminUserController@addCredit')->name('admin.users.addcredit');
	//Route::get('/{locationid}/percentages/create/','AdminLocationpercentagesController@create')->name('admin.percentages.create');
	Route::get('/transactions/show/{transactionid}', 'AdminLocationTransactionsController@show')->name('admin.transactions.show');
	//Route::post('/{locationid}/percentages','AdminLocationpercentagesController@store')->name('admin.percentages.store');
	//timings
	Route::get('{locationid}/timings', 'AdminLocationsTimingsController@index')->name('admin.locations.timings');
	Route::get('{locationid}/timings/edit', 'AdminLocationsTimingsController@edit')->name('admin.locations.timings.edit');
	Route::post('/{locationid}/timings/edit', 'AdminLocationsTimingsController@update')->name('admin.locations.timings.update');
	Route::post('/{location_id}/timings', 'AdminLocationsTimingsController@store')->name('admin.locations.timings.store');

	//location types
	Route::get('/locationtypes/restoremodel/{locationtype}', 'AdminLocationTypeController@restoremodel')->name('admin.locationtypes.restoremodel');
	Route::get('/locationtypes/softdelete/{locationtype}', 'AdminLocationTypeController@destroy')->name('admin.locationtypes.destroy');
	Route::get('/locationtypes/create', 'AdminLocationTypeController@create')->name('locationtypes.create');
	Route::get('/locationtypes/{locationtype}', 'AdminLocationTypeController@redisCreate')->name('admin.locationtypes.redisCreate');
	Route::get('/locationtypes', 'AdminLocationTypeController@index')->name('admin.locationtypes');

	Route::post('/locationtypes', 'AdminLocationTypeController@store')->name('locationtypes.store');
	//servicecategories
	Route::get('/servicecategories/create', 'AdminServiceCategoriesController@create')->name('admin.servicecategories.create');
	Route::get('/servicecategories/{servicecategory}', 'AdminServiceCategoriesController@redisCreate')->name('admin.servicecategories.redisCreate');
	Route::get('/servicecategories/restoremodel/{servicecategory}', 'AdminServiceCategoriesController@restoremodel')->name('admin.servicecategories.restoremodel');
	Route::get('/servicecategories/softdelete/{servicecategory}', 'AdminServiceCategoriesController@destroy')->name('admin.servicecategories.destroy');


	Route::post('/servicecategories/create', 'AdminServiceCategoriesController@store')->name('admin.servicecategories.store');
	Route::post('/servicecategories/update/{servicecategory}', 'AdminServiceCategoriesController@update')->name('admin.servicecategories.update');
	Route::get('/servicecategories', 'AdminServiceCategoriesController@index')->name('admin.servicecategories');
	Route::get('/servicecategories/{servicecategory}', 'AdminServiceCategoriesController@edit')->name('admin.servicecategories.edit');

	//employees
	Route::get('/employee/restoremodel/{employee}', 'AdminEmployeeController@restoremodel')->name('admin.employee.restoremodel');
	Route::get('/employee/softdelete/{employee}', 'AdminEmployeeController@destroy')->name('admin.employee.destroy');
	Route::get('{locationid}/employee', 'AdminEmployeeController@index')->name('admin.employee');
	Route::get('/{locationid}/employee/create/', 'AdminEmployeeController@create')->name('admin.employee.create');
	Route::get('/{locationid}/employee/show/{id}', 'AdminEmployeeController@show')->name('admin.employee.show');

	Route::post('/employee/store', 'AdminEmployeeController@store')->name('admin.employee.store');
	Route::post('/employee/edit/{employee}', 'AdminEmployeeController@update')->name('admin.employee.edit');
	Route::get('/employee/attach/{employee}/{service}', 'AdminEmployeeController@attach')->name('admin.employee.attach');
	Route::get('/employee/dettach/{employee}/{service}', 'AdminEmployeeController@detach')->name('admin.employee.detach');
	//auth
	Route::get('password/reset', 'Manager\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('password/email', 'Manager\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('password/reset/{token}', 'Manager\ResetPasswordController@showResetForm')->name('admin.password.reset');
	Route::post('password/reset', 'Manager\ResetPasswordController@reset');
	Route::get('/partners/newpartneremail/{manager}', 'AdminPartnerController@newpartneremail')->name('admin.partners.newpartneremail');
	Route::get('/partners/emailconfirmed/{manager}', 'AdminPartnerController@emailconfirmed')->name('admin.partners.emailconfirmed');
	Route::get('/partners/restoremodel/{partner}', 'AdminPartnerController@restoremodel')->name('admin.partners.restoremodel');
	Route::get('/partners/softdelete/{partner}', 'AdminPartnerController@destroy')->name('admin.partners.destroy');
	Route::get('/partners/redisdoall', 'AdminPartnerController@redisdoall')->name('admin.redisdoall');
	Route::get('/partners/create', 'AdminPartnerController@create')->name('admin.createpartner');
	Route::post('/partners/register', 'AdminPartnerController@register')->name('admin.partners.store');
	Route::get('/partners', 'AdminPartnerController@index')->name('admin.partners');
	Route::get('/', 'AdminPartnerController@index')->name('admin.main');
});

