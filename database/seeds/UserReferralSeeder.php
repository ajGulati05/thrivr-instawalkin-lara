<?php

use Illuminate\Database\Seeder;
use App\Http\Traits\v2\UserReferralTrait;
use App\User;

class UserReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=User::all();

        foreach($users as $user){
          User::generateReferral($user);

        }
    }
}
