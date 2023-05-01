<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerProfiilesIcs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_profiles', function (Blueprint $table) {
               $table->text('ics_url')->nullable();
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
               $table->dropColumn('ics_url');
              });
    }
}
