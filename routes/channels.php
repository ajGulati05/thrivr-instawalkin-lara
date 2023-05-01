<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('timekit_booking', function ($request) {

//   Log::debug('CHANNEL PASSING');
//   Log::debug($request);

//     return true;
// });
use Illuminate\Support\Facades\Log;
Broadcast::channel('App.User.{id}', function($user,$id){
  return (int) $user->id === (int) $id;
});



Broadcast::channel('App.Manager.{id}.bookings', function ($manager,$id) { 
Log::debug($manager);
Log::debug($id);
return (int) $manager->id===(int) $id;
 });