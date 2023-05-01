<?php

use Illuminate\Database\Seeder;
use App\ManagerProfile;		
use Grimzy\LaravelMysqlSpatial\Types\Point;

class FixManagerPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $managerProfiles=ManagerProfile::all();


        foreach($managerProfiles as $managerProfile){

        	$position=new Point($managerProfile->latitude, $managerProfile->longitude);
        	$managerProfile->position=$position;
        	$managerProfile->save();
           
        }
    }
}
