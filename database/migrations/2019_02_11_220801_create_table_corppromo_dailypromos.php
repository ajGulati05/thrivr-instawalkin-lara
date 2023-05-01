<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCorppromoDailypromos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

            Schema::create('corporationpromos', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->increments('id'); //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->text('name');
             $table->string('code', 32)->unique();
             $table->integer('percent');
             $table->text('comment')->nullable();
             $table->date('start_date');
              $table->date('end_date');
             $table->timestamps();
            });  

            Schema::create('corporationpromo_users', function (Blueprint $table) {
            $table->unsignedInteger('corporationpromos_id');
            $table->unsignedInteger('users_id');
            $table->boolean('validated')->default(0);
            $table->timestamps();
            $table->foreign('corporationpromos_id')->references('id')->on('corporationpromos');
            $table->foreign('users_id')->references('id')->on('users');
            });  

        Schema::create('dailypromos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('locationtype_id');
             $table->integer('percent');
             $table->text('comment')->nullable();
             $table->date('start_date');
              $table->date('end_date');
             $table->timestamps();
             $table->foreign('locationtype_id')->references('id')->on('locationtypes');
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

        Schema::dropIfExists('corporationpromos');
        Schema::dropIfExists('corporationpromo_users');
        Schema::dropIfExists('dailypromos');

    }
}
