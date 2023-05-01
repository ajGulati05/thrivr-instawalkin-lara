<?php

namespace App\Http\Traits\v2;

use Illuminate\Support\Facades\Log;
use App\User;
use App\Guest;
use App\Booking;
use App\Manager;
trait MergeGuestToUserTrait
{



  public function onVerification(Guest $guest){


    $user=$guest->user;
    $manager=$guest->manager;
    $this->migrateBookings($guest,$user);
    $this->migrateIntakeForms($guest,$user);
  $this->migrateCovidForms($guest,$user);
    $this->assignUserToTherapist($user,$manager);
  $this->confirmMigration($guest);
  }
  public function onAcceptance(Guest $guest){
      $user=$guest->user;
      $manager=$guest->manager;
      $this->assignUserToTherapist($user,$manager);
       $this->confirmMigration($guest);
  }
   
   
  //function that will assign all 
  //previous bookings for a guest to a user on verification
  public function migrateBookings($guest,User $user)
  {
      $allBookings=$guest->books;


foreach ($allBookings as $booking) {
    $booking->bookable_id = $user->id;
    $booking->bookable_type='App\User';
    $booking->saveQuietly();
  }

  }

   //function that will assign all 
  //previous intakeforms for a guest to a user on verification
  public function migrateIntakeForms(Guest $guest,User $user){
        $guestIntakeForms=$guest->intakeforms();
        $guestIntakeForms->intakeformable_id = $user->id;
        $guestIntakeForms->intakeformable_type='App\User';
        $guestIntakeForms->save();
  }


   //function that will assign all 
  //previous covidforms for a guest to a user on verification
  public function migrateCovidForms(Guest $guest, User $user){
          $guestCovidForms=$guest->covidForms();
         $guestCovidForms->covidformable_id = $user->id;
         $guestCovidForms->covidformable_type='App\User';
         $guestCovidForms->save();
  }

     //function that will add client to therapist
  public function assignUserToTherapist(User $user, Manager $manager){


       $manager->clients()->syncWithoutDetaching($user);
  }


public function confirmMigration(Guest $guest){
     $guest->migrated=true;
     $guest->save();
}

}
