<?php

use App\User;
use Illuminate\Database\Seeder;

class UserRewardSeeder extends Seeder
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
            $user->rewards()->create();
        }
    }
}
