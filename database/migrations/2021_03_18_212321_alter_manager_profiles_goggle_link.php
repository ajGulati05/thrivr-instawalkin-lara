<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerProfilesGoggleLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_profiles', function (Blueprint $table) {
               $table->text('google_address_link')->nullable();
              
                
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
                $table->dropColumn('google_address_link');
              
                });
    }
}
