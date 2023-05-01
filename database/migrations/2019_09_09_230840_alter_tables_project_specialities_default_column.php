<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesProjectSpecialitiesDefaultColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('default')->nullable();
            $table->string('mobile_name')->nullable();
           
        });
         Schema::table('manager_specialities', function (Blueprint $table) {
            $table->boolean('default')->nullable();
           
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('projects', function (Blueprint $table) {
           $table->dropColumn(['default','mobile_name']);
        });
          Schema::table('manager_specialities', function (Blueprint $table) {
            $table->dropColumn(['default']);
        });
    }
}
