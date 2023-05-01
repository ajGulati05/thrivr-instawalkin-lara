<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('schedulecodes', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
         
        });
           Schema::table('dayschedules', function (Blueprint $table) {
                $table->string('schedulecode')->nullable()->references('code')->on('schedulecodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedulecodes');
    }
}
