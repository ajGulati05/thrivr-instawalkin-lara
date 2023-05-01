<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('afterstatuscodes', function (Blueprint $table) {
            //$table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
         
        });
            Schema::table('transactions', function (Blueprint $table) {
               
                $table->integer('servicecategory_id')->references('id')->on('servicecategories')->nullable();
                $table->string('afterstatus')->references('code')->on('afterstatuscodes')->nullable();
                
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
         Schema::dropIfExists('afterstatuscodes');
    }
}
