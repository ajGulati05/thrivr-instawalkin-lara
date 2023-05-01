<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;
use App\Guest;
use App\UserGuest;
class UserUUIDTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //

        $users=User::all();
         $Guests=Guest::all();
          $UserGuests=UserGuest::all();

        foreach($users as $user){


            
        	$user->update([
	    	 'instauuid'=>(string) Str::orderedUuid()
        ]);
        }


         foreach($Guests as $Guest){


            
            $Guest->update([
             'instauuid'=>(string) Str::orderedUuid()
        ]);
        }


         foreach($UserGuests as $UserGuest){


            
            $UserGuest->update([
             'instauuid'=>(string) Str::orderedUuid()
        ]);
        }
    }
}
