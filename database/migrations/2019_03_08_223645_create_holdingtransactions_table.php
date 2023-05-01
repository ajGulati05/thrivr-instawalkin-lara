<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldingtransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

      
    public function up()
    { 
        Schema::create('holdingtransactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('price_id');
            $table->unsignedInteger('servicecategories_id');
            $table->integer('distance');
            $table->float('userlocation_lat',10,6);
            $table->float('userlocation_lng',10,6);
            $table->date('servicedate');
            $table->dateTime('service_starttime');
            $table->dateTime('service_endtime');
            $table->float('creditamount',10,2)->nullable();
            $table->float('promoamount',10,2)->nullable();
            $table->string('promocode', 32)->nullable();
            $table->integer('corporatepercent')->nullable();
            $table->string('corporatecode',32)->nullable();
            $table->boolean('approved');
            $table->text('comment')->nullable();
            $table->string('statuscode',1)->default('W'); // W for waiting, D for denied, A for Accepted
            $table->boolean('read')->default(0);
            $table->text('locationinfo');
            $table->foreign('servicecategories_id')->references('id')->on('servicecategories');
            $table->foreign('price_id')->references('id')->on('instaprices');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

          Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedInteger('holdingtransactions_id')->nullable();
                $table->foreign('holdingtransactions_id')->references('id')->on('holdingtransactions');
                $table->boolean('read')->default(0);
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holdingtransactions');
    }
}
