<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('reciepts', function (Blueprint $table) {
                $table->boolean('duplicate')->default(1);
                $table->timestamps();
                $table->dropColumn('sent_on');
             });


           Schema::create('reviews', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->increments('id');
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->unsignedInteger('transaction_id');
             $table->integer('review_score')->nullable();
             $table->text('review_comment')->nullable();
             $table->timestamps();
             $table->foreign('transaction_id')->references('id')->on('transactions');

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
        Schema::dropIfExists('reviews');
    }
}
