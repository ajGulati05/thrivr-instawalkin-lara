<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaunchedCitiesTimezone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('launched_cities', function (Blueprint $table) {
            
            $table->text('timezone')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('launched_cities', function (Blueprint $table) {
            
            $table->dropColumn('timezone');
           
        });
    }
}
