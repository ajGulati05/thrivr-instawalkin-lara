<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRmtteamDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('rmt_teams', function (Blueprint $table) {
             $table->string('long_description',2000)->nullable()->change();
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('rmt_teams', function (Blueprint $table) {
               $table->string('long_description',2000)->nullable()->change();
                
        });
    }
}
