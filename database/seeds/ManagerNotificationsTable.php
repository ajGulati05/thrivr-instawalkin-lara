<?php

use Illuminate\Database\Seeder;
use App\Manager;
class ManagerNotificationsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $managers=Manager::all();


        foreach($managers as $manager){


            
        	 DB::table('manager_notifications')->insert([
	    	 'manager_id'=>$manager->id
        ]);
        }
    }
}
