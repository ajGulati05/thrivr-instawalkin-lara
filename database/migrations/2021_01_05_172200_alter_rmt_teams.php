<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRmtTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('rmt_teams', function (Blueprint $table) {
            $table->string('short_description')->default('');
            $table->string('long_description')->default('');

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
            $table->dropColumn(['short_description','long_description']);
        });
    }
}
