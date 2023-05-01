<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('days', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->string('description');
        }); 
       Schema::create('timings', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->string('location_id')->references('id')->on('locations');
            $table->string('day_id')->references('id')->on('locations');
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->time('stat_open')->nullable();
            $table->time('stat_close')->nullable();
            $table->timestamps();
        });
         Schema::create('notification_limit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->unique();
            $table->integer('value_minutes');
        });
        Schema::create('notifications_off', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_id');
            $table->string('notification_limit_id')->references('id')->on('notification_limit');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('days');
        Schema::dropIfExists('notification_limit');
        Schema::dropIfExists('timings');
        Schema::dropIfExists('notifications_off');
    }
}
