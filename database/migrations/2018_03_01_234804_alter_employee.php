<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('notificationcodes', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
         
        });
           Schema::table('employees', function (Blueprint $table) {
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('notificationcode')->default('N')->references('code')->on('notificationcodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificationcodes');
    }
}
