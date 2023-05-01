<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeandPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('employees', function (Blueprint $table) {
                $table->softDeletes();
                 $table->integer('location_id');
                $table->dropColumn(['active']);
                $table->dropColumn(['manager_id']);
        });
         Schema::table('locationtypes', function (Blueprint $table) {
                $table->text("logo")->nullable();;
        });
        Schema::table('locations', function (Blueprint $table) {
                $table->text("logo")->nullable();
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
