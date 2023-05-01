<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerProfilesNoMoreClients extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('manager_profiles', function (Blueprint $table) {
              
               $table->boolean('taking_clients')->default(1);
                
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
                $table->dropColumn('taking_clients');
   
                });
    }
}
