<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReviewTable extends Migration
{
         /** @return void
     */
    public function up()
    {
       
           Schema::table('reviews', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
           
    
             $table->boolean('verified')->default(0);
        
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
         
             $table->dropColumn(['verified']);
             //varied prices will be used to figure out wether notifications need to have an assigned employee
            
        }); 
    }
}
