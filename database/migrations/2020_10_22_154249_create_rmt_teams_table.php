<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRmtTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rmt_teams', function (Blueprint $table) {
            $table->id();
            $table->text('slug');
            $table->unsignedBigInteger('launched_cities_id');
            $table->foreign('launched_cities_id')->references('id')->on('launched_cities');
            $table->timestamps();

        });

           Schema::create('managerrmtteams', function (Blueprint $table) {
            $table->unsignedInteger('manager_id');
            $table->unsignedBigInteger('rmt_team_id');
            $table->foreign('manager_id')->references('id')->on('managers');
             $table->foreign('rmt_team_id')->references('id')->on('rmt_teams');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                 Schema::dropIfExists('managerrmtteams');
                Schema::dropIfExists('rmt_teams');

    }
}
