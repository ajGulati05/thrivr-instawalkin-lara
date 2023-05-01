<?php

use Illuminate\Database\Seeder;

class TruncateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   /*protected $toTruncate = ['endorsement_review','holdingtransactions','credithistorys','receipts','reciepts','secondary_emails','availability_constraints','transactions','blocked_users','booking_transactions','reviews','booking_pricings','bookings','projectpricings_taxes','taxes','project_pricings','projects','managers_projects','manager_notifications','manager_licenses','endorsements','manager_profiles','manager_secondary_email','managers_specialities','managers'];*/
   protected $toTruncate = ['endorsement_review','reviews','user_notifications','availability_constraints','manager_notifications'];
    public function run()
    {
        Schema::disableForeignKeyConstraints();
           foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
           
        }
      Schema::enableForeignKeyConstraints();
      
    }
}
