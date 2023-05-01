<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
       //$this->call([TruncateTableSeeder::class,EndorsementTableSeeder::class,ProjectTableSeeder::class,ProjectPricingTableSeeder::class,TaxesTableSeeder::class,ManagersTableSeeder::class,ReviewsTableSeeder::class]); 
       // $this->call([ReviewTableRepliesSeeder::class]);
   //$this->call([ReviewTableRepliesSeeder::class]); 

      $this->call([TruncateTableSeeder::class,AvailabilityConstraintTable::class,UsernotificationsTable::class,ManagerNotificationsTable::class,UserUUIDTableSeeder::class,FixManagerPointSeeder::class,ConnectClientTherapistSeeder::class, PromocodeSeeder::class]); 
    }
}


