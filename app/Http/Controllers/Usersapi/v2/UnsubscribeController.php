<?php

namespace App\Http\Controllers\Usersapi\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Guest;


class UnsubscribeController extends Controller
{


 public function unsubscribeGuest(){
  $guest=Guest::where('instauuid',$instauuid)->first();

  $guest->email_reminder=!$guest->email_reminder;
  $guest->save();
  $title='We are sad to see you go!';
  $sub='You have been unsubscribed and will no longer get reminder emails';
  $sad=1;
  if($usernotifications->email_reminder){
    $title='You are now subscribed';
     $sub='You will continue to receive reminder for your appointments. Yay!';
    $sad=0;
  }

 return view('unsubscribe', ['title' => $title, 'sad'=>$sad,'sub'=>$sub]);
 }  

 public function unsubscribeUser($instauuid){

  $user=User::where('instauuid',$instauuid)->first();
  $usernotifications = $user->usernotifications;
  $usernotifications->email_reminder=!$usernotifications->email_reminder;
  $usernotifications->save();
   $title='We are sad to see you go!';
   $sub='You have been unsubscribed and will no longer get reminder emails';
  $sad=1;
  if($usernotifications->email_reminder){
    $title='Thanks for staying with us!';
    $sub='You will continue to receive reminder for your appointments. Yay!';
     $sad=0;
  }

 return view('unsubscribe', ['title' => $title, 'sad'=>$sad,'sub'=>$sub]);
 } 



public function unsubscribeFutureGuest(){
  $guest=Guest::where('instauuid',$instauuid)->first();

  $guest->future_reminder=!$guest->future_reminder;
  $guest->save();
  $title='We are sad to see you go!';
  $sub='You have been unsubscribed and will no longer get reminder emails';
  $sad=1;
  if($usernotifications->future_reminder){
    $title='You are now subscribed';
     $sub='You will continue to future reminders. Yay!';
    $sad=0;
  }

 return view('unsubscribe', ['title' => $title, 'sad'=>$sad,'sub'=>$sub]);
 }  

 public function unsubscribeFutureUser($instauuid){

  $user=User::where('instauuid',$instauuid)->first();
  $usernotifications = $user->usernotifications;
  $usernotifications->future_reminder=!$usernotifications->future_reminder;
  $usernotifications->save();
   $title='We are sad to see you go!';
   $sub='You have been unsubscribed and will no longer get reminder emails';
  $sad=1;
  if($usernotifications->future_reminder){
    $title='Thanks for staying with us!';
    $sub='You will continue to receive future reminders. Yay!';
     $sad=0;
  }

 return view('unsubscribe', ['title' => $title, 'sad'=>$sad,'sub'=>$sub]);
 }



    public function unsubscribeUpdateUser($instauuid){

        $user=User::where('instauuid',$instauuid)->first();
        $usernotifications = $user->usernotifications;
        $usernotifications->product_update=!$usernotifications->product_update;
        $usernotifications->save();
        $title='We are sad to see you go!';
        $sub='You have been unsubscribed and will no longer get product update emails';
        $sad=1;
        if($usernotifications->product_update){
            $title='Thanks for staying with us!';
            $sub='You will continue to receive future produt updates. Yay!';
            $sad=0;
        }

        return view('unsubscribe', ['title' => $title, 'sad'=>$sad,'sub'=>$sub]);
    }
}


