<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableManagerProfilesAddDescriptionForAddress extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_profiles', function (Blueprint $table) {
               $table->string('address_description')->nullable();
               $table->string('parking_description')->nullable();
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('manager_profiles', function (Blueprint $table) {
               $table->dropColumn(['address_description','parking_description']);
              
        });
    }
}
