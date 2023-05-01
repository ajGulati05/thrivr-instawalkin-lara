<?php

use Illuminate\Database\Seeder;
use App\Manager;
class AvailabilityConstraintTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        $Managers=Manager::all();


        foreach($Managers as $Manager){


            
        	 DB::table('availability_constraints')->insert([
	    	 'manager_id'=>$Manager->id
        ]);
        }
    }
}
