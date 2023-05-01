<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
           Schema::table('reviews', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
            $table->dropForeign(['transaction_id']);
             $table->dropColumn(['transaction_id','review_score','review_comment']);
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->unsignedInteger('booking_id')->nullable();
             $table->morphs('review');
             $table->unsignedInteger('manager_id')->nullable();
             $table->text('comment')->nullable();
             $table->integer('score')->nullable();
             $table->integer('parent_id')->unsigned()->default(0);
        
             $table->foreign('booking_id')->references('id')->on('bookings');
             $table->foreign('manager_id')->references('id')->on('managers');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('reviews', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->dropForeign(['booking_id','manager_id']);
             $table->dropColumn(['booking_id','manager_id','comment','score']);
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->unsignedInteger('transaction_id');
             $table->integer('review_score')->nullable();
             $table->text('review_comment')->nullable();
            
             $table->foreign('transaction_id')->references('id')->on('transactions');

        }); 
    }
}
